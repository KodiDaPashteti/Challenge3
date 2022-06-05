<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="styles.css" rel="stylesheet">
  <title>Challenge 3</title>
</head>
<body>

    <nav class="flex items-center justify-between flex-wrap bg-gray-900 p-6">
                <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
                <div class="text-sm lg:flex-grow">
                
                    <a href="/history.php" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4">
                    History
                    </a>
                    <a href="/index.php" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white">
                    Search
                    </a>
                </div>
    </nav>
    
    <form action="/index.php" method="POST" enctype="multipart/form-data">
        <div class="flex min-h-screen w-full items-center justify-center bg-gray-900">
            <div class="flex rounded bg-white w-[30rem]" x-data="{ search: '' }">
                <input
                type="search"
                class="w-full border-none bg-transparent px-4 py-1 text-gray-900 outline-none focus:outline-none"
                placeholder="Search"
                name="searchtail"
                />

                <button
                type="submit"
                class="m-2 rounded px-4 px-4 py-2 font-semibold text-red-500"
                :class="(search.length > 0) ? 'bg-purple-500' : 'bg-gray-500 cursor-not-allowed'"
                :disabled="search.length == 0"
                >
                Search
                </button>
            </div>
        </div>
    </form>

    <?php
    
        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=digimon_chars', 'root' , '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $digimon = $_POST["searchtail"];
        $api_url = "https://digimon-api.vercel.app/api/digimon/name/".$digimon;
        

        $ch = curl_init();

        curl_setopt_array($ch,[
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => 1
        ]);

        $digimon_data = curl_exec($ch); 
        $digimon_data_array = json_decode($digimon_data,TRUE);

        $digimon_name = $digimon_data_array[0]['name'];
        $digimon_img_url = $digimon_data_array[0]['img'];
        $digimon_level = $digimon_data_array[0]['level'];

        curl_close($ch);

        $stmt = $pdo->prepare("SELECT * FROM digimons WHERE namePK=?");
        $stmt->execute([$digimon]); 
        $user = $stmt->fetch();

        if ($user) {
            $st2 = $pdo->prepare("SELECT * FROM digimons WHERE namePK like '%$digimon%'");
            $st2->execute();
            $display_digimon = $st2->fetchAll(PDO::FETCH_ASSOC);
    ?>
            <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-4 py-12">
                    <div
                    class="w-full bg-gray-900 rounded-lg sahdow-lg p-12 flex flex-col justify-center items-center"
                    >
                    <div class="mb-8">
                        <div class="radial-progress bg-accent text-accent-content border-4 border-accent" style="--size:7rem; --value: 70">
                            <img src=<?php echo $display_digimon[0]["img"] ?> >
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-xl text-white font-bold mb-2"><?php echo $display_digimon[0]["namePK"] ?></p>
                    </div>
                    <div class="text-center">
                        <p class="text-xl text-white font-bold mb-2"><?php echo $display_digimon[0]["level"] ?></p>
                        <p class="text-base text-gray-400 font-normal">________________________________________</p>
                    </div>  
            </section>

        <?php } else {
            
            $stmnt = $pdo->prepare("INSERT INTO digimons (namePK, img, level) 
                        VALUES (:name, :img, :level)");
            $stmnt->bindValue(':name',$digimon_name);
            $stmnt->bindValue(':img',$digimon_img_url);
            $stmnt->bindValue(':level',$digimon_level);

            $stmnt->execute();

            $st3 = $pdo->prepare("SELECT * FROM digimons WHERE namePK like '%$digimon%'");
            $st3->execute();
            $display_digimon2 = $st3->fetchAll(PDO::FETCH_ASSOC);
        ?>
            <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-4 py-12">
                        <div
                        class="w-full bg-gray-900 rounded-lg sahdow-lg p-12 flex flex-col justify-center items-center"
                        >
                        <div class="mb-8">
                            <div class="radial-progress bg-accent text-accent-content border-4 border-accent" style="--size:7rem; --value: 70">
                                <img src=<?php echo $display_digimon2[0]["img"] ?> >
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-xl text-white font-bold mb-2"><?php echo $display_digimon2[0]["namePK"] ?></p>
                        </div>
                        <div class="text-center">
                            <p class="text-xl text-white font-bold mb-2"><?php echo $display_digimon2[0]["level"] ?></p>
                            <p class="text-base text-gray-400 font-normal">________________________________________</p>
                        </div>  
                </section>
        <?php    
        }
        ?>
</body>
</html>





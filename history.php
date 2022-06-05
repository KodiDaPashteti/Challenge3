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
    
<?php
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=digimon_chars', 'root' , '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $statement = $pdo->prepare('SELECT * FROM digimons');
    $statement->execute();
    $digimons = $statement->fetchAll(PDO::FETCH_ASSOC);


?>
    <div class="bg-gray-900 py-20 lg:py-[120px] overflow-hidden relative z-10">
        <div class="container xl:max-w-6xl mx-auto px-4">
            <header class="text-center mx-auto mb-12 lg:px-20">
                <h2 class="text-2xl leading-normal mb-2 font-bold text-white">
                Already Searched Digimons
                </h2>
            </header>
        </div>

        <?php foreach ($digimons as $digimon) { ?>
            <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-4 py-12">
                    <div
                    class="w-full bg-gray-900 rounded-lg sahdow-lg p-12 flex flex-col justify-center items-center"
                    >
                    <div class="mb-8">
                        <div class="radial-progress bg-accent text-accent-content border-4 border-accent" style="--size:7rem; --value: 70">
                            <img src=<?php echo $digimon["img"] ?> >
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-xl text-white font-bold mb-2"><?php echo $digimon["namePK"] ?></p>
                    </div>
                    <div class="text-center">
                        <p class="text-xl text-white font-bold mb-2"><?php echo $digimon["level"] ?></p>
                        <p class="text-base text-gray-400 font-normal">________________________________________</p>
                    </div>  
            </section>
        <?php } ?>
    </div>




</body>
</html>





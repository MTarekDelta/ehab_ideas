<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <body>

        <?php

          class Chef{

            function makeChicken(){
                echo "The chef makes chicken <br>";
            }

            function makeSalad(){
                echo "The chef makes salad <br>";
            }

            function makeSpecialDish(){
                echo "The chef makes bbq <br>";
            }

          }


        

           class ItalianChef extends Chef{

                function makePasta(){
                    echo "The Chef makes pasta";
                }

                // overriding the prev function
                function makeSpecialDish(){
                    echo "The Chef makes chicken parm";
                }

           }

          $chef = new Chef();
          $chef->makeSpecialDish();


          $italianChef = new ItalianChef();
          $italianChef->makeSpecialDish();



        ?>

    </body>
</html>
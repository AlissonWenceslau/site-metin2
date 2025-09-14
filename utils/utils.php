<?php
function pgClass($job)
{
    switch ($job) {
        case 0:
            return '<img src="./assets/ranking/0.png">';
        case 1:
            return '<img src="./assets/ranking/1.png">';
        case 2:
            return '<img src="./assets/ranking/2.png">';
        case 3:
            return '<img src="./assets/ranking/3.png">';
        case 4:
            return '<img src="./assets/ranking/4.png">';
        case 5:
            return '<img src="./assets/ranking/5.png">';
        case 6:
            return '<img src="./assets/ranking/6.png">';
        case 7:
            return '<img src="./assets/ranking/7.png">';
    }
}

function pgKingdom($kingdom)
{
    switch ($kingdom) {
        case 1:
            return '<img src="./assets/ranking/shinso.jpg">';
        case 2:
            return '<img src="./assets/ranking/chunjo.jpg">';
        case 3:
            return '<img src="./assets/ranking/jinno.jpg">';
    }
}
?>
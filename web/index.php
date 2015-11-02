<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
require __DIR__ . '/../config/autoload.php';

use Layer\Connector\ConectBd;
use Users\User;

?>
    <p>добавить в базу</p>
    <form action="" method="post">
        <input type="text" name="name" placeholder="name">
        <input type="text" name="surname" placeholder="surname">
        <input type="submit" name='add'>
    </form>
    <p>удалить с базы</p>
    <form action="" method="post">
        <input type="number" name="id" placeholder="id">
        <input type="submit">
    </form>
    <p>обновить данные</p>
    <form action="" method="post">
        <input type="number" name="idUpdate" placeholder="id">
        <input type="text" name="nameUpdate" placeholder="name">
        <input type="text" name="surnameUpdate" placeholder="surmane">
        <input type="submit">
    </form>
<?php

$bd = new ConectBd();
$data = $bd->connect($config['host'], $config['db_user'], $config['db_password'], $config['database']);

$table = $bd->createTableUser();

$userData = new User([
    'name' => 'Ruslan',
    'surname' => 'Koval'
]);
$bd->insert($userData->params['name'], $userData->params['surname']);







if (@$_REQUEST['add'])
{
    if (isset($_POST['name']) && isset($_POST['surname']))
    {
        $bd->insert(htmlspecialchars($_POST['name']), htmlspecialchars($_POST['surname']));
    }
}

if (isset($_POST['id']))
{
    $remove = $bd->remove(' user ',$_POST['id']);
}

if (isset($_POST['idUpdate']) && isset($_POST['nameUpdate']) && isset($_POST['surnameUpdate']))
{
    $update = $bd->update(htmlspecialchars($_POST['nameUpdate']),htmlspecialchars($_POST['surnameUpdate']),htmlspecialchars($_POST['idUpdate']));
}


$rez = $bd->findAll(' user');

echo '<table border="1"><p>findAll</p>';
foreach ($rez as $key => $value)
{
    echo '<tr>';
    echo '<td>' . $value['id'] . '</td>';
    echo '<td>' . $value['name'] . '</td>';
    echo '<td>' . $value['surname'] . '</td>';
    echo '</tr>';
}
echo '</table>';

$arrayParam =
    [
        'name'    => 'Vasya',
        'surname' => 'Pupkin'
    ];

$findBy = $bd->findBy('user',$arrayParam);

echo '<table border="1"><p>findBy</p>';

foreach ($findBy as $key => $value)
{
    echo '<tr>';
    echo '<td>' . $value['id'] . '</td>';
    echo '<td>' . $value['name'] . '</td>';
    echo '<td>' . $value['surname'] . '</td>';
    echo '</tr>';
}
echo '</table>';





$bd->connectClose($bd);


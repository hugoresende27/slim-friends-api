<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;


$app = AppFactory::create();

//get all friends
$app->get('/friends/all', function (Request  $request, Response $response) {

    $sql = "SELECT * FROM friends";

    try {

       $db = new Db();
       $conn = $db->connect();
       $res =  $conn->query($sql);
       $friends = $res->fetchAll(PDO::FETCH_OBJ);
       $db = null;
       $response->getBody()->write(json_encode($friends));
       return $response
           ->withHeader('content-type','application/json')
           ->withStatus(200);

    } catch (PDOException $e) {

        $error = array(
            'message' => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(500);

    }
});


//get friend by ID
$app->get('/friends/{id}', function (Request  $request, Response $response, array $args) {

    $id = $args['id'];
    $sql = "SELECT * FROM friends WHERE id = $id";

    try {

       $db = new Db();
       $conn = $db->connect();
       $res =  $conn->query($sql);
       $friend = $res->fetch(PDO::FETCH_OBJ);
       $db = null;
       $response->getBody()->write(json_encode($friend));
       return $response
           ->withHeader('content-type','application/json')
           ->withStatus(200);

    } catch (PDOException $e) {

        $error = array(
            'message' => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(500);

    }
});


//add new friend (POST)
$app->post('/friends/add', function (Request  $request, Response $response) {

    $email = $request->getParam('email');
    $displayName = $request->getParam('display_name');
    $phone = $request->getParam('phone');



    $sql = "INSERT INTO friends (email,display_name,phone) VALUE (:email, :display_name, :phone)";

    try {

       $db = new Db();
       $conn = $db->connect();

       $res =  $conn->prepare($sql);
       $res->bindParam(':email', $email);
       $res->bindParam(':display_name', $display_name);
       $res->bindParam(':phone', $phone);

       $addFriend = $res->execute();

       $db = null;

       $response->getBody()->write(json_encode($addFriend));
       return $response
           ->withHeader('content-type','application/json')
           ->withStatus(200);

    } catch (PDOException $e) {

        $error = array(
            'message' => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(500);

    }
});


//delete a friend (DELETE)
$app->delete('/friends/{id}', function (Request  $request, Response $response, array $args) {

    $id = $args['id'];
    $sql = "DELETE FROM friends WHERE id = $id";

    try {

       $db = new Db();
       $conn = $db->connect();

       $res =  $conn->prepare($sql);

       $removeFriend = $res->execute();

       $db = null;

       $response->getBody()->write(json_encode($removeFriend));
       return $response
           ->withHeader('content-type','application/json')
           ->withStatus(200);

    } catch (PDOException $e) {

        $error = array(
            'message' => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(500);

    }
});
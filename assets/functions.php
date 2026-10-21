<?php

require_once __DIR__ . '/config/db.php';

function insertForumpost($username, $message) {
    $sql = "insert into forum (username, message) 
    values (:username, :msg)";

    global $forum;

    $stmt = $forum->prepare($sql);

    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':msg', $message);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function getForumPosts() {
    $sql = "select * from forum order by time desc";

    global $forum;
    $stmt = $forum->prepare($sql);
    $stmt->execute();
    return $stmt;
}

function loggain($email, $password) {
    global $forum;

    if ($email === '' || $password === '') {
        return false;
    }

    $sql = 'SELECT Frisörid AS frisor_id, Namn AS name, Email AS email, Lösenord AS password
            FROM `Frisör` WHERE Email = :email';
    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return false;
    }

    $storedPassword = (string)$user['password'];
    if ($storedPassword === '') {
        return false;
    }

    if (!password_verify($password, $storedPassword)) {
        if (!hash_equals($storedPassword, $password)) {
            return false;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $update = $forum->prepare('UPDATE `Frisör` SET Lösenord = :password WHERE Frisörid = :id');
        $update->execute([
            ':password' => $passwordHash,
            ':id' => $user['frisor_id']
        ]);
    } elseif (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $update = $forum->prepare('UPDATE `Frisör` SET Lösenord = :password WHERE Frisörid = :id');
        $update->execute([
            ':password' => $passwordHash,
            ':id' => $user['frisor_id']
        ]);
    }

    unset($user['password']);
    return $user;
}

function addFrisor(array $frisor) {
    global $forum;

    $statement = $forum->prepare(
        'INSERT INTO `Frisör` (Namn, Email, Lösenord) VALUES (:name, :email, :password)'
    );
    $statement->execute([
        ':name' => $frisor['name'],
        ':email' => $frisor['email'],
        ':password' => $frisor['password']
    ]);

    return (int)$forum->lastInsertId();
}

function frisorEmailExists($email, $exceptId = null) {
    global $forum;

    $sql = 'SELECT 1 FROM `Frisör` WHERE Email = :email';
    if ($exceptId !== null) {
        $sql .= ' AND Frisörid != :id';
    }
    $statement = $forum->prepare($sql);
    $parameters = [':email' => $email];
    if ($exceptId !== null) {
        $parameters[':id'] = $exceptId;
    }
    $statement->execute($parameters);

    return (bool)$statement->fetchColumn();
}
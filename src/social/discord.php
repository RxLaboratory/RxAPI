<?php

    //configuration and init 
    include ("../config.php");
    include ("../functions.php");
    include ("../init.php");

    $userAgent = "DiscordBot (http://rxlaboratory.org, {$RxAPIVersion})";

    $embed = array(
        'title' => 'Un beau titre',
        'description' => 'La description',
        'url' => 'https://rxlaboratory.org',
        'color' => 123,
        'author' => array(
            'name' => 'The RxLab Team',
            'https://rxlaboratory.org'
        )
    );

    $data = array(
        'content' => '@everyone Test message',
        'embeds' => array( $embed )
    );

    $post_data = json_encode($data);

    $ch = curl_init( "https://discord.com/api/webhooks/1005131476209254470/qMKCn_tAM5uXq0PYRZOlXJsuD6sOE9e8PxzV6Tf_eapsEajoxwt7jqbQOLXjGBCor-69" );
    curl_setopt($ch, CURLOPT_HTTPHEADER,
        array(
            "User-Agent: {$userAgent}",
            "Content-Type: application/json;charset=utf-8"//,
            //"Authorization: Bot {$discordBotToken}"
        )
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    echo $response;

?>
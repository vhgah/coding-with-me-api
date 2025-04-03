<?php

return [
    'discord' => [
        /**
         * The Discord webhook URL to upload files to.
         */
        'image' => [
            'url' => env('DISCORD_IMAGE_URL', 'https://discord.com/api/webhooks/1354813140474396702/M7A6o7ABNQntkGEJGB1NaPOTJL1zyOkLyyUReqEUMQfcRpwsvwN78MO2NYMNw52Cuccl'),
            'max_size' => 5120,
            'allowed_types' => ['jpg', 'jpeg', 'png', 'gif'],
        ],
    ],
];

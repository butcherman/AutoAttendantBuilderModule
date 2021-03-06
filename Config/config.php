<?php

return [
    /*
    *   Basic Module Information - Name and Version
    */
    'name' => 'AutoAttendantBuilderModule',
    'ver'  => '0.0.0-beta',

    /**
     * If non-registered users are allowed to use this tool or not
     */
    // 'allow_public_access' => false,
    'allow_public_access' => true,

    /**
     * How long to save AA builds in the database for in days
     */
    'save_for' => 30,

    /**
     * Allow anyone to download the JSON data for saving the AA builds on their own
     */
    'allow_download' => true,

    /*
    *   Information for the Navbar
    */
    'navbar' => [],

    /**
     * If you would rather have a button link on the Dashboard page, use this section
     */
   'dashboard_tool' => [
    //    [
    //        'name'  => 'Auto Attendant Builder',
    //        'icon'  => 'fas fa-headset',
    //        'route' => 'AutoAttendantBuilderModule.index',
    //    ],
   ],

    /*
    *   Information for the Administration home page navigation links
    */
    'admin_nav' => [
//         [
// //          'perm_name' => null,                                    //  Name of a specific Permission that will allow this link
//             'name'      => 'AutoAttendantBuilderModule',
//             'icon'      => 'fas fa-tools',
//             'route'     => 'AutoAttendantBuilderModule.index',
//         ],
    ],

    /*
    *   Notes if there are migrations that need to be added to the database
    */
    'has_migrations' => false,

    /*
    *   Location for uploaded files - Uncomment if this Module needs its own Disk instance
    */
    'disks' => [
//        'AutoAttendantBuilderModule' => [
//            'driver' => 'local',
//            'root'   => storage_path('app/AutoAttendantBuilderModule'),
//        ],
    ],
];

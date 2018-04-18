<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
        this is define token validate time in minute
    |
    */

    /*if you want to token neverinvalid  just comment below line other wise provide time into minute */

    'valid' => 60, /* menute */

    /*=============================================
    =      define invlid token beetween two date =
    ------ date should be format in yyyy/dd/mm------

    ex. if you want to stop access of api login or register user between specific date
    =============================================*/
                                                                                                                                                                                                                                                                                                                        
    'stop_login' => false,

    /* date format should be yyyy/mm/dd */
    'to_date' => null , 
    'from_date' => null,
    /*=====  End  ======*/
    /*want to autheticate date with model object*/
    'login_date' => true,
    /*Verify payload with a data base record. Becuase some time after generating token user deleted from database. If token is generated and after some time user deleted from database. What happen user have their authentication token so if a double_verify is on then user check with also database otherwise remote-auth verify only token is valid*/ 
    'double_verify' => true,
    /**/  
    
];

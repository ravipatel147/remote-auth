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

    // 'valid' => 60,

    /*=============================================
    =      define invlid token beetween two date =
    ------ date should be format in yyyy/dd/mm------

    ex. if you want to stop access of api login or register user between specific date
    =============================================*/
                                                                                                                                                                                                                                                                                                                        
    'STOP_LOGIN' => false,

    /* date format should be yyyy/mm/dd */

    'TO_DATE' => null , 
    'FROM_DATE' => null,
    
    /*=====  End  ======*/


    /*=============================
    =            model            =
    =============================*/
    
    'MODEL' => 'App\User',
    
    /*=====  End of model  ======*/
    
    
];

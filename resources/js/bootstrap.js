window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
    // require('admin-lte');
    require('bootstrap-vue');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});
/*
axios.get('/affairs').then( (resp) => console.log(resp) )


axios.post('/affairs',
    {
        "affair":{
            "name":"original file",
            "description": "take original file for ASTU"
        },
        "procedures":[
            {
                "name":"Go to Registrar",
                "description":"Go to this bureau",
                "pre_request":[
                    {
                        "name":"pay cost share",
                        "description": "you have to pay cost share",
                        "affair_id":null
                    },
                    {
                        "name":"",
                        "description": "",
                        "affair_id":2,
                    }
                ]
            },
            {
                "name":"go to bureau number 8",
                "description":"They will handle your request",
                "pre_request":[
                    {
                        "name":"make sure you have photograph 3x4",
                        "description": "Photo that display on your orignal file",
                        "affair_id":null
                    },
                    {
                        "name":"",
                        "description": "",
                        "affair_id":2,
                    }
                ]
            }
        ]
    })
    .then(resp => console.log(resp)).catch(error=>console.log(error))
    */

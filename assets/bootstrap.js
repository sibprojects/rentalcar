import { startStimulusApp } from '@symfony/stimulus-bridge';

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));

// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);

require('bootstrap');
require("bootstrap-datepicker/js/bootstrap-datepicker.js");
require("bootstrap-datepicker/dist/css/bootstrap-datepicker.standalone.css");

const $ = require('jquery');

$(document).ready(function() {
    // you may need to change this code if you are not using Bootstrap Datepicker
    $('.js-datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
    });

    // refresh car rental information wher change dates
    if( $('#rentTotalInfo').length > 0){
        $('.js-datepicker').datepicker().on('changeDate', function () {
            let url = location.href.split('?')[0] +
                '?from_date=' + $('#rental_form_date_start').val() +
                '&to_date=' + $('#rental_form_date_end').val();
            $.get(url, function (html){
                let div = $('<div></div>').html(html);
                $('#rentTotalInfo').html(div.find('#rentTotalInfo').html());
            });
        });
    }

//    $('[data-toggle="popover"]').popover();
});

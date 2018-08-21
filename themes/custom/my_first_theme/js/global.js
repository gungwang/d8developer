(function ($, Drupal, drupalSettings) {

  'use strict';

  Drupal.behaviors.mybehavior = {
    attach: function (context, settings) {

      console.log(drupalSettings);
      $('h1.page-title').click(function(){
        $('#search-block-form').toggle(300);
      }) ;
    }
  };

})(jQuery, Drupal, drupalSettings);

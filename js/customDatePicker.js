var customDatePickerRules = Marionette.Object.extend( {
    initialize: function() {
      this.listenTo( Backbone.Radio.channel( 'pikaday' ), 'init', this.modifyDatepicker );
    },

    modifyDatepicker: function( dateObject, fieldModel ) {
      var startDate = new Date(fieldModel.get('date_range_start'));
      var endDate = new Date(fieldModel.get('date_range_end'));

      if(!nfDatepickerValidation.isValidDate(startDate) || !nfDatepickerValidation.isValidDate(endDate) || endDate < startDate ) return;

      var enabled = nfDatepickerValidation.enabledDates(startDate, endDate);
      dateObject.pikaday._o.disableDayFn = function( date ) {
        if ( _.indexOf( enabled, moment( date ).format( "YYYY-MM-DD" ) ) === -1 ) {
            return true;
        }
      }
    }
});

jQuery( document ).ready( function() {
	new customDatePickerRules();
} );

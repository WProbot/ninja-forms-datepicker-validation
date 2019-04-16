var DatepickerFieldController = Marionette.Object.extend( {
  initialize: function() {
    var submitChannel = Backbone.Radio.channel( 'submit' );
    this.listenTo( submitChannel, 'validate:field', this.validate );

    var fieldsChannel = Backbone.Radio.channel( 'fields' );
    this.listenTo( fieldsChannel, 'change:modelValue', this.validate );
  },

  validate: function( model ) {
    var startDate = new Date(model.get('date_range_start'));
    var endDate = new Date(model.get('date_range_end'));

    if(!nfDatepickerValidation.isValidDate(startDate) || !nfDatepickerValidation.isValidDate(endDate) || endDate < startDate ) return;

    var date = new Date(model.get('value'));
    var enabled = nfDatepickerValidation.enabledDates(startDate, endDate);
    if ( _.indexOf( enabled, moment( date ).format( "YYYY-MM-DD" ) ) !== -1 ) {
      Backbone.Radio.channel( 'fields' ).request( 'remove:error', model.get( 'id' ), 'custom-field-error' );
    } else {
      Backbone.Radio.channel( 'fields' ).request( 'add:error', model.get( 'id' ), 'custom-field-error', 'Date must be between ' + moment(startDate).format("MM-DD-YYYY") + ' and ' +  moment(endDate).format("MM-DD-YYYY") + '.');
    }
  }
});

jQuery( document ).ready( function( $ ) {
  new DatepickerFieldController();
});

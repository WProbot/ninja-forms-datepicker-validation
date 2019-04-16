nfDatepickerValidation = {
  enabledDates: function(start, end) {
    var enableDate = new Date();
    var startCopy = new Date(start.getTime());
    var enabled = [];

    for (var d = startCopy; d <= end; d.setDate(d.getDate() + 1)) {
      enabled.push(moment( new Date(d) ).format( "YYYY-MM-DD" ));
    }
    return enabled;
  },
  isValidDate: function(d) {
    return d instanceof Date && !isNaN(d);
  }
}

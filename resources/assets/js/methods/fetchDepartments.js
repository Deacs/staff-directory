module.exports = function(bounds) {

    var endpoint = '/api/departments';

    if (bounds != null && Object.getOwnPropertyNames(bounds).length > 0) {
        if (bounds.location != '') {
            endpoint = '/api/locations/'+bounds.location+'/departments';
        }
    }

    this.$http.get(endpoint, function(departments) {

        //console.log('Fetching Departments');
        //
        //console.log(endpoint);
        //
        //console.log(departments);

        this.departments = departments;
    });
}

module.exports = function(slug) {
    this.$http.get('/api/department/'+slug, function(department) {
        this.department = department;
    });
};

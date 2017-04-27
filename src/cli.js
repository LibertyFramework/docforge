
var join = require("path").join;
var exec = require("child_process").exec;

module.exports = {
    /**
     *
     * @param args
     */
    run: function (args) {
        console.log(args);

        var path = join(process.cwd(), "elegy");
        exec(join(__dirname, "../exec/build.sh") + " " + path, function(a,b,c) {

            console.log(a,b,c);

        });
    }
};
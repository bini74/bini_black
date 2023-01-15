Chart.defaults.global.responsive = true;
// Get the HTML canvas by its id 
plots = document.getElementById("plots");

// Example datasets for X and Y-axes 
var days = ["01/01", "02/01", "03/01", "04/01", "05/01", "06/01", "07/01", "08/01", "09/01", "10/01"]; //Stays on the X-axis 
var traffic = [430, 410, 420, 410, 440, 450, 463, 420, 480, 490, 450]; //Stays on the Y-axis 

var options = {
    maintainAspectRatio : false,
    legend: {
        display: false,
 //Remove the legend box by setting it to false. It's true by default.
        },
    title : {
        display : true,
        text : 'Poids'
    },
};
// Create an instance of Chart object:
new Chart(plots, {
type: 'line', //Declare the chart type
options: options,
data: {
labels: days, //X-axis data 
datasets: [{
data: traffic, //Y-axis data 
backgroundColor: '#36A2EB80',
borderColor: '#36A2EB80',
fill: false, //Fills the curve under the line with the babckground color. It's true by default 
}]
},

});

Chart.defaults.global.responsive = true;
// Get the HTML canvas by its id 
taille = document.getElementById("taille");

// Example datasets for X and Y-axes 
var days = ["01/01", "02/01", "03/01", "04/01", "05/01", "06/01", "07/01", "08/01", "09/01", "10/01"]; //Stays on the X-axis 
var traffic = [430, 410, 420, 410, 440, 450, 463, 420, 480, 490, 450]; //Stays on the Y-axis 

var options = {
    maintainAspectRatio : false,
    legend: {
        display: false,
 //Remove the legend box by setting it to false. It's true by default.
        },
    title : {
        display : true,
        text : 'Taille'
    },
};
// Create an instance of Chart object:
new Chart(taille, {
type: 'line', //Declare the chart type
options: options,
data: {
labels: days, //X-axis data 
datasets: [{
data: traffic, //Y-axis data 
backgroundColor: '#36A2EB80',
borderColor: '#36A2EB80',
fill: false, //Fills the curve under the line with the babckground color. It's true by default 
}]
},

});


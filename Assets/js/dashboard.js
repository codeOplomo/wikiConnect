console.log(84684 );
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [{
      label: 'Berber rugs',
      data: [12, 15, 3, 5, 6, 3],
      backgroundColor: [
        'rgba(57, 118, 67)',

      ],
      borderColor: [
        'rgba(57, 118, 67)',

      ],
      borderWidth: 1
    },
    {
      label: 'moroccan tajines',
      data: [17, 12, 19, 8, 7, 6],

      backgroundColor: [
        'rgba(214, 204, 153)',

      ],
      borderColor: [
        'rgba(214, 204, 153)',

      ],
      borderWidth: 1
    }
    ]

  },
  options: {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    }
  }
});

// var ctx = document.getElementById('myChart').getContext('2d');
//         var myChart = new Chart(ctx, {
//             type: 'bar',
//             data: {
//                 labels: ['Label 1', 'Label 2', 'Label 3'],
//                 datasets: [{
//                     label: 'My Dataset',
//                     data: [10, 20, 30],
//                     backgroundColor: 'rgba(75, 192, 192, 0.2)',
//                     borderColor: 'rgba(75, 192, 192, 1)',
//                     borderWidth: 1
//                 }]
//             },
//             options: {
//                 scales: {
//                     y: {
//                         beginAtZero: true
//                     }
//                 }
//             }
//         });


//line
var ctxL = document.getElementById("lineChart").getContext('2d');
var myLineChart = new Chart(ctxL, {
  type: 'line',
  data: {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [{
      label: "berber rugs",
      data: [65, 59, 80, 81, 56, 55, 40],
      backgroundColor: [
        'rgba(57, 118, 67)',
      ],
      borderColor: [
        'rgba(57, 118, 67)',
      ],
      borderWidth: 2
    },
    {
      label: " morroccan tajines",
      data: [28, 48, 40, 19, 86, 27, 90],
      backgroundColor: [
        'rgba(214, 204, 153)',
      ],
      borderColor: [
        'rgba(214, 204, 153)',
      ],
      borderWidth: 2
    }
    ]
  },
  options: {
    responsive: true
  }
});




//////////////////////

// Sidebar Toggler
document.querySelector('.sidebar-toggler').addEventListener('click', function () {
  document.querySelector('.sidebar').classList.toggle('open');
  document.querySelector('.content').classList.toggle('open');
  return false;
});



const dashboard = document.getElementById('content-container');
const articlesSection = document.getElementById('articles-section');
const artisansSection = document.getElementById('artisans-section');
const articlesLink = document.getElementById('article-link');
const artisanLink = document.getElementById('artisan-link');
const dashboardLink = document.getElementById('dashboard-link');

function showArticlesSection() {
  artisansSection.style.display = 'none';
  dashboard.style.display = 'none';
  articlesSection.style.display = 'block';

  artisanLink.classList.remove('active');
  dashboardLink.classList.remove('active');
  articlesLink.classList.add('active');
}

function showDashboardSection() {
  articlesSection.style.display = 'none';
  artisansSection.style.display = 'none';
  dashboard.style.display = 'block';

  articlesLink.classList.remove('active');
  artisanLink.classList.remove('active');
  dashboardLink.classList.add('active');
}

function showArtisanSection() {
  dashboard.style.display = 'none';
  articlesSection.style.display = 'none';
  artisansSection.style.display = 'block';

  articlesLink.classList.remove('active');
  dashboardLink.classList.remove('active');
  artisanLink.classList.add('active');
}

articlesLink.addEventListener('click', showArticlesSection);
artisanLink.addEventListener('click', showArtisanSection);
dashboardLink.addEventListener('click', showDashboardSection);
showDashboardSection();


//form toogler
document.addEventListener('DOMContentLoaded', function () {
  // Get the form section element
  var formSection = document.querySelector('.form-section');

  // Get the "Ajouter" button element
  var ajoutProduitButton = document.getElementById('ajout-produit');

  // Add click event listener to the "Ajouter" button
  ajoutProduitButton.addEventListener('click', function () {
    // Toggle the visibility of the form section
    formSection.style.display = (formSection.style.display === 'none') ? 'table-row' : 'none';
  });

  // Get the form element
  var formElement = document.querySelector('form');

  // Add submit event listener to the form
  formElement.addEventListener('submit', function () {
    // Hide the form section when submitting the form
    formSection.style.display = 'none';
  });
});


$(document).ready(function () {
  // Triggered when the modal is about to be shown
  $('#exampleModalCenter').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var row = button.data('row'); // Get the JSON string from data-row attribute

    // Update input values with the row data
    $('#produitInputModal').val(row.nom);
    $('#descInputModal').val(row.description);
    $('#ctgrInputModal').val(row.categorie_Id);
  });
});

$(document).ready(function () {
  // Attach a click event to the search button
  $('#searchButton').click(function () {
      // Get the search query from the input field
      var query = $('#searchInput').val();

      // Perform AJAX request
      $.ajax({
          type: 'GET',
          url: 'search.php', // Replace with the actual URL for your search logic
          data: { query: query },
          success: function (response) {
              // Handle the response, e.g., update a div with the search results
              $('#searchResults').html(response);
          },
          error: function (error) {
              console.log('Error:', error);
          }
      });
  });
});


//artisan form section 

document.addEventListener('DOMContentLoaded', function () {
  var artisanFormSection = document.querySelector('.artisanForm-section');
  var ajoutArtisanButton = document.getElementById('ajout-artisan');

  console.log(ajoutArtisanButton);
  ajoutArtisanButton.addEventListener('click', function () {
      artisanFormSection.classList.toggle('d-none');
  });
});


// $(document).ready(function () {
//   // Hide the form section initially
//   $('.form-section').hide();

//   // Show the form section when clicking "Ajouter" button
//   $('#ajout-produit').on('click', function () {
//     $('.form-section').show();
//   });

//   // Hide the form section when clicking submit button
//   $('form').submit(function () {
//     $('.form-section').hide();
//   });
// });


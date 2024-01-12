

document.getElementById('add-category-button').addEventListener('click', function () {
  var addCategoryForm = document.getElementById('add-category-form');
  if (addCategoryForm.style.display === 'none' || addCategoryForm.style.display === '') {
      addCategoryForm.style.display = 'block';
  } else {
      addCategoryForm.style.display = 'none';
  }
});

document.getElementById('close-category-form').addEventListener('click', function () {
  var addCategoryForm = document.getElementById('add-category-form');
  addCategoryForm.style.display = 'none';
});

document.getElementById('add-tag-button').addEventListener('click', function () {
  var addTagForm = document.getElementById('add-tag-form');
  if (addTagForm.style.display === 'none' || addTagForm.style.display === '') {
      addTagForm.style.display = 'block';
  } else {
      addTagForm.style.display = 'none';
  }
});

document.getElementById('close-tag-form').addEventListener('click', function () {
  var addTagForm = document.getElementById('add-tag-form');
  addTagForm.style.display = 'none';
});


function filterTable() {
var selectedCategory = document.getElementById('categoryFilter').value;
var selectedTag = document.getElementById('tagFilter').value.trim(); // Remove leading/trailing spaces
var rows = document.querySelectorAll('.table tbody tr');

rows.forEach(function (row) {
if (shouldDisplayRow(row, selectedCategory, selectedTag)) {
row.style.display = '';
} else {
row.style.display = 'none';
}
});
}

function shouldDisplayRow(row, selectedCategory, selectedTag) {
var categoryCell = row.querySelector('td[data-category-id]');
var categoryId = categoryCell.getAttribute('data-category-id');

var tagCell = row.querySelector('.tag-cell');
var tags = tagCell.getAttribute('data-tags').split(', ');

var categoryMatch = selectedCategory === 'all' || selectedCategory === categoryId;
var tagMatch = selectedTag === 'all' || tags.includes(selectedTag);

return categoryMatch && tagMatch;
}

document.getElementById('categoryFilter').addEventListener('change', filterTable);
document.getElementById('tagFilter').addEventListener('change', filterTable);


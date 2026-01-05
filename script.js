
const modal = document.getElementById('studentFormModal');
const openBtn = document.getElementById('openFormBtn');
const closeBtn = document.getElementById('closeModal');

// Open modal
openBtn.onclick = () => modal.style.display = 'block';

// Close modal
closeBtn.onclick = () => modal.style.display = 'none';

// Close modal if clicking outside
window.onclick = (event) => {
    if (event.target === modal) modal.style.display = 'none';
};

// Add/Edit/Delete students
const form = document.getElementById('studentForm');
const table = document.getElementById('studentTable').getElementsByTagName('tbody')[0];

form.addEventListener('submit', function(e) {

    const firstName = document.getElementById('firstName').value;
    const lastName = document.getElementById('lastName').value;
    const course = document.getElementById('course').value;
    const yearLevel = document.getElementById('yearLevel').value;
    const subject = document.getElementById('subject').value;
    const finalGrade = document.getElementById('finalGrade').value;
    const semester = document.getElementById('semester').value;
    const academicYear = document.getElementById('academicYear').value;

    const row = table.insertRow();
    row.innerHTML = `
        <td>${table.rows.length}</td>
        <td>${firstName} ${lastName}</td>
        <td>${subject}</td>
        <td>${finalGrade}</td>
        <td>${semester}</td>
        <td>${academicYear}</td>
        <td>
            <button onclick="editRow(this)">Edit</button>
            <button onclick="deleteRow(this)">Delete</button>
        </td>
    `;

    form.reset();
    modal.style.display = 'none';
    alert('Student added successfully!');
});

// Delete row
function deleteRow(btn) {
    if (confirm('Are you sure you want to delete this student?')) {
        const row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
}

// Edit row
function editRow(btn) {
    const row = btn.parentNode.parentNode;
    const cells = row.getElementsByTagName('td');

    // Fill modal form
    const fullName = cells[1].innerText.split(' ');
    document.getElementById('firstName').value = fullName[0] || '';
    document.getElementById('lastName').value = fullName[1] || '';
    document.getElementById('subject').value = cells[2].innerText;
    document.getElementById('finalGrade').value = cells[3].innerText;
    document.getElementById('semester').value = cells[4].innerText;
    document.getElementById('academicYear').value = cells[5].innerText;

    // Open modal
    modal.style.display = 'block';

}

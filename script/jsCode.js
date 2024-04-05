

function populateNote(id, title, desc, dates){
    document .getElementById('nid').innerHTML = id;
    document .getElementById('ntitle').innerHTML = title;
    document .getElementById('ndesc').innerHTML = desc;
    document .getElementById('ndate').innerHTML = dates;
    console.log(id,title,desc,dates);
}

function openForm(){
    document.getElementById('overNote').style.display = 'flex';
    document.getElementById('title').value = "";
    document.getElementById('descrip').value = "";
}
function openNote(){
    document.getElementById('viewNote').style.display = 'flex';

}
function closeNote(){
    document.getElementById('viewNote').style.display = 'none';

}
function closeForm(){
    document.getElementById('overNote').style.display = 'none';
    document.getElementById('title').value = "";
    document.getElementById('descrip').value = "";
}
// function submited(){
//     document.getElementById('title').value = "";
//     document.getElementById('descrip').value = "";
// }
// views.addEventListener('click',openNote);
addNote.addEventListener('click',openForm);
cancel.addEventListener('click',closeForm);
// add.addEventListener('click', submited);


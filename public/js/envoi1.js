

var formValid = document.getElementById('envoi1');
var author = document.getElementById('author');
var commentaire = document.getElementById('commentaire');
var missAuthor = document.getElementById('missAuthor');
var missCommentaire = document.getElementById('missCommentaire');
var nomValid = /^[a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]+([-'\s][a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]+)?$/;
var comValid = /^[a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]+([-'\s][a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]+)?$/;
formValid.addEventListener('click',validation);
function validation(event){
    //si le champ est vide 
    if(author.validity.valueMissing){
        event.preventDefault();
        missAuthor.textContent = 'Nom Manquant';
        missAuthor.style.color = 'red';
    }
    else if (nomValid.test(author.value) == false){
        event.preventDefault();
        missAuthor.textContent = 'Format incorrect';
        missAuthor.style.color = 'orange';
    }
     
     
       if(commentaire.validity.valueMissing){
            event.preventDefault();
            missCommentaire.textContent = 'texte Manquant';
            missCommentaire.style.color = 'red';  
    }
    else if (comValid.test(commentaire.value) == false){
        event.preventDefault();
        missCommentaire.textContent = 'Format incorrect';
        missCommentaire.style.color = 'orange';
    }
};
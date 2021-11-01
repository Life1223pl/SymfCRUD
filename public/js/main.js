const articles = document.getElementById('articles');

if(articles){
    articles.addEventListener('dblclick', e => {
       if(e.target.className === 'btn btn-danger delete-article'){
           alert("2");
       }
    });
}
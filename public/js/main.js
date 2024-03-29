const articles = document.getElementById('expenses');

if (articles){
    articles.addEventListener('click', e => {
        if(e.target.className === 'btn btn-danger delete-article') {
            if (confirm('Are you sure?')) {
                const id = e.target.getAttribute('data-id');

                fetch(`/expense/delete/${id}`, {method: 'DELETE'}).
                then(res => window.location.reload());
            }
        }
    });
}
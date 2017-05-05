var Article = React.createClass({
    render: function () {
        var article = this.props.article;
        date = new Date(article.pubDate);
        return (
            <div className="article media-object" key={article.id}>
                { article.image && <div className="media-object-section">
                    <div className="mh-image-crop large" style={{backgroundImage: 'url(' + article.image + ')'}}></div>
                </div>
                }
                <div className="media-object-section main-section">
                    <h2><a href={"/" + article.slug}>{article.title}</a></h2>
                    <div className="metadata">
                        <span className="date left">{ date.toLocaleDateString('es-ES') }</span>
                        <span className="channel right">
                        <a href={"/blog/" + article.blog_slug}>{ article.blog_title }</a>
                    </span>
                    </div>
                    <p><a href={"/" + article.slug} className="button secondary small">Leer más</a></p>

                </div>
            </div>
        )
    }
});


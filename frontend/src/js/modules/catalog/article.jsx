var Article = React.createClass({
    render: function () {
        var article = this.props.article;
        date = article.pubDate.replace(/(\d+)-(\d+)-(\d+).*/, '$3/$2/$1');
        return (
            <div className="article media-object" key={article.id}>
                <FeedArticleImage size="large" image={article.image}/>

                <div className="media-object-section main-section">
                    <h2><a href={"/" + article.slug}>{article.title}</a></h2>
                    <FeedArticleMetadata date={date} slug={article.blog_slug} label={article.blog_title}/>
                    <p></p>
                    <p><a href={"/" + article.slug} className="button secondary small">Leer más</a></p>

                </div>
            </div>
        )
    }
});

var FeedArticleImage = React.createClass({
    render: function () {
        if (this.props.image) {
            return (
                <div className="media-object-section">
                    <div className={"mh-image-crop " + this.props.size}
                         style={{backgroundImage: 'url(' + this.props.image + ')'}}></div>
                </div>
            )
        }
        return (null);
    }
});

var FeedArticleMetadata = React.createClass({
    render: function () {
        return (
            <div className="metadata">
                <span className="date left">{ this.props.date } </span>
                <span className="channel right"><a href={"/blog/" + this.props.slug }>{ this.props.label }</a></span>
            </div>

        )
    }
});

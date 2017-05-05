var CatalogArticleList = React.createClass({
    render: function () {
        var articles = this.props.data.map(function (article) {
                return (
                    <Article key={article.id} article={article}/>
                );
            }
        );
        return (
            <div className="articles">
                {articles}
            </div>
        );
    }
});

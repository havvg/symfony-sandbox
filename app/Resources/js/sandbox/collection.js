jQuery(function($) {
    $('.btn-add[data-target]').live('click', function(event) {
        var collectionHolder = $('#' + $(this).attr('data-target'));

        if (!collectionHolder.attr('data-counter')) {
            collectionHolder.attr('data-counter', collectionHolder.children().length);
        }

        var prototype = collectionHolder.attr('data-prototype');
        var form = prototype.replace(/__name__/g, collectionHolder.attr('data-counter'));

        collectionHolder.attr('data-counter', Number(collectionHolder.attr('data-counter')) + 1);
        collectionHolder.append(form);

        event && event.preventDefault();
    });

    $('.btn-remove[data-related]').live('click', function(event) {
        var name = $(this).attr('data-related');
        $('*[data-content="'+name+'"]').remove();

        event && event.preventDefault();
    });
});

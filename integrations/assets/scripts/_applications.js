(function($) {

    // selects the buttons
    var add_custom_links = $('.add-custom-links');
    if (!add_custom_links.length) {
        return;
    }

    // event listener on click for buttons
    add_custom_links.on('click', function(e) {
        e.preventDefault();

        // selects the first row of the parent-container and clones it
        var parent_container = $(this).parent('.form-group').prev('.custom-row');
        var new_row = parent_container.find('.row').first().clone();

        // loops over the inputs in the clone to reset their values
        new_row.find('input[type="text"]').each(function(index) {
            var name_parts = $(this).attr('name').split('_');
            var num = parseInt(name_parts.pop()) + 1;
            name_parts.push(num);

            $(this).val('')
                   .attr('name', name_parts.join('_'));
        });

        // removes the label
        new_row.find('label').remove();

        // appends the cloned row in the parent container
        parent_container.append(new_row);
    });

})(jQuery);
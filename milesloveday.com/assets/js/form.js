import '../css/form.scss';


['cv_employers', 'cv_skills', 'cv_educators', 'cv_interests'].forEach((propName) => {

    const addEntityForm = ($collectionHolder, $newLinkLi) => {
        // Get the data-prototype explained earlier
        const prototype = $collectionHolder.data('prototype');
        // get the new index
        const index = $collectionHolder.data('index');
        let newForm = prototype;

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        newForm = newForm.replace(/__name__/g, index);
        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a {thing}" link li
        const $newFormLi = jQuery('<div></div>').append(newForm);
        $newLinkLi.before($newFormLi);
    };

    jQuery(document).ready(() => {
        const $collectionHolder = $(`#${propName}`);
        const $addButton = $(`<button type="button" class="add_link btn-primary btn">Add ${propName}</button>`);
        const $newLinkLi = $('<div></div>').append($addButton);

        $collectionHolder.append($newLinkLi);
        // count the current form inputs we have (e.g. 2), use that as the new
        // index when inserting a new item (e.g. 2)
        $collectionHolder.data('index', $collectionHolder.find(':input').length);

        $addButton.on('click', function (e) {
            addEntityForm($collectionHolder, $newLinkLi);
        });
    });
});
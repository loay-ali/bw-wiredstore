(function($){
    
    const qa_list = $('#bw-qa-list tbody');

    //Add New Item.
    $('body').on('click','#bw-add-new-qa',(e) => {

        const $ele = $('<tr></tr>');
        const last_index = Array.from(qa_list.find("tr")).length;

        $ele.append('<td>'+ (last_index + 1) +'</td>');
        $ele.append('<td><input type = "text" name = "bw_content_qa[title][]"/></td>');
        $ele.append('<td><textarea name = "bw_content_qa[content][]"></textarea></td>');
        $ele.append('<td><button type = "button" class = "bw-remove-qa"><i class = "dashicons dashicons-trash"></i></button></td>');
    
        qa_list.append($ele);
    });

    //Remove Item.
    $('body').on('click','.bw-remove-qa',(e) => {

        const $ele = $(e.currentTarget);

        $ele.parents('tr').remove();

        refill_indexes();
    });

    function refill_indexes() {

        let index = 1;

        qa_list.find('tr').each((ind,ele) => {

            $(ele).find('td:first-of-type').text(index++);
        });
    }

})(jQuery);
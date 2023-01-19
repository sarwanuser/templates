var disbaledbtn = 0;
var i = 0;


var change_room = document.getElementById('change_room').value;
var select_kids = document.getElementById('select_kids');
var select_kids5 = document.getElementById('select_kids5');
var select_adult = document.getElementById('select_adult');
var select_rooms = document.getElementById('select_rooms');
if (select_rooms.value == "") {
    select_adult.disabled = true;
    select_kids.disabled = true;
    select_kids5.disabled = true;
}
function change_val(ele) {
    change_room = ele.value;
    let val = ele.value;
    if (val != "0") {
        select_adult.disabled = false;
        select_adult.innerHTML = '<option value="0">Select Adult</option>';
        let new_val = parseInt(val) * parseInt(3);
        for (i = 0; i < new_val; i++) {
            select_adult.innerHTML += `
        <option value="${i + 1}">${i + 1}</option>`;
        }
    }
    else {
        select_adult.disabled = true;
        select_kids.disabled = true;
        select_kids5.disabled = true;
    }
}
function change_kids(ele) {
    let val = ele.value;
    let room_val = select_rooms.value;
    let room_limit = parseInt(room_val) * parseInt(4)
    if (val != "0") {
        select_kids.disabled = false;
        select_kids5.disabled = false;
        select_kids.innerHTML = '<option value="0">Select Kids</option>';
        select_kids5.innerHTML = '<option value="0">Select Kids</option>';
        let new_val = parseInt(room_limit) - parseInt(val);
        for (i = 0; i < new_val; i++) {
            select_kids.innerHTML += `
        <option value="${i + 1}">${i + 1}</option>`;
            select_kids5.innerHTML += `
        <option value="${i + 1}">${i + 1}</option>`;
        }

    }
    else {
        select_kids.disabled = false;
        select_kids5.disabled = false;
        select_kids.innerHTML = '<option value="0">Select Kids</option>';
        select_kids5.innerHTML = '<option value="0">Select Kids</option>';
        let new_val = parseInt(room_limit);
        for (i = 0; i < new_val; i++) {
            select_kids.innerHTML += `
        <option value="${i + 1}">${i + 1}</option>`;
            select_kids5.innerHTML += `
        <option value="${i + 1}">${i + 1}</option>`;
        }

    }
}
function change_kids5(ele) {
    let val = ele.value;
    console.log(val)
    let room_val = select_rooms.value;
    let adult_val = select_adult.value;
    let room_limit = parseInt(room_val) * parseInt(4);
    if (val != "0") {
        select_kids5.disabled = false;
        select_kids5.innerHTML = '<option value="0">Select Kids</option>';
        let new_val = parseInt(room_limit) - parseInt(adult_val) - parseInt(val);
        if (new_val > 0) {
            select_kids5.disabled = false;
            for (i = 0; i < new_val; i++) {
                select_kids5.innerHTML += `
            <option value="${i + 1}">${i + 1}</option>`;
            }
        }
        else {
            select_kids5.disabled = true;
        }
    }
    else {
        select_kids5.disabled = false;
        select_kids5.innerHTML = '<option value="">Select Kids</option>';
        let new_val = parseInt(room_limit) - parseInt(adult_val);
        for (i = 0; i < new_val; i++) {
            select_kids5.innerHTML += `
        <option value="${i + 1}">${i + 1}</option>`;
        }
    }
}
var total_room = 0;
function check_room() {
    if (document.getElementById('total_price').innerHTML == '0') {
        alert("Select your room first");
        return false;
    }
    else if (total_room != change_room) {
        alert(`Select ${change_room} room`);
        return false;
    }



}
function add_card(element, view) {
    var room_no = jQuery(element).parent().find(".no_counter").html();
    var x = jQuery(element).parent().find(".no_counter");
    var arr = x.attr('class').split(' ');
    if (room_no > change_room || $('#sidebar-card').children().length > change_room) {
        alert(`You have selected only ${change_room} rooms`);
        element.removeAttribute('data-toggle');
        element.removeAttribute('data-target');
        var addremove = jQuery(element).parent().find('.plus_count')
        $(addremove).removeData("toggle");
        $(addremove).removeData("target");

        return false;
    }
    if ($('#sidebar-card').find(`#${arr[1]}`).length > 0) {
        alert('You have already selected this room');
        element.removeAttribute('data-toggle');
        element.removeAttribute('data-target');
        return false;
    }
    if ((total_room + parseInt(room_no)) > change_room) {

        alert(`You have selected only ${change_room} rooms`);
        var addremove = jQuery(element).parent().find('.plus_count');
        $(addremove).removeData("toggle");
        $(addremove).removeData("target");
        return false;
    } else {
        total_room = total_room + parseInt(room_no);
    }

    var price = jQuery(element).parent().parent().find(".room_rate_offe_price").find('.price').html();
    var type = jQuery(element).parent().parent().find(".meal_type_des").html();
    // For room type
    var hide_input = jQuery(element).parent().find(".hide_input");
    var hide_price = jQuery(element).parent().find(".hide_price");

    price = price * room_no;
    if ($('#sidebar-card').children().length > 0) {

        var t_p = $('#total_price').html();
        t_p = parseInt(t_p) + parseInt(price);

        $('#total_price').html(t_p);
        $('#tp').val(t_p);
        let new_limit = room_no * 4;
        document.getElementById('member_adults').innerHTML = '<option value="0">--Select Adults--</option>';
        for (i = 0; i < new_limit - room_no; i++) {
            document.getElementById('member_adults').innerHTML += `<option value="${i + 1}">${i + 1}</option>`;
        }
        document.getElementById('member_kids').innerHTML = '<option value="0">--Select Kids--</option>';
        for (i = 0; i < new_limit; i++) {
            document.getElementById('member_kids').innerHTML += `<option value="${i + 1}">${i + 1}</option>`;
        }

    }
    else {
        $('#total_price').html(price);
        $('#tp').val(price);
        let new_limit = room_no * 4;
        document.getElementById('member_adults').innerHTML = '<option value="0">--Select Adults--</option>';
        for (i = 0; i < new_limit - room_no; i++) {
            document.getElementById('member_adults').innerHTML += `<option value="${i + 1}">${i + 1}</option>`;
        }
        document.getElementById('member_kids').innerHTML = '<option value="0">--Select Kids--</option>';
        for (i = 0; i < new_limit; i++) {
            document.getElementById('member_kids').innerHTML += `<option value="${i + 1}">${i + 1}</option>`;
        }
    }
    if (view == 'classic') {
        new_view = 'Classic-Valley View';
        var tot_classic = $('#classic_room').val();
        var total_room_classic = parseInt(tot_classic) + parseInt(room_no);
        $('#classic_room').val(total_room_classic);
    }
    else if (view == 'deluxe') {
        new_view = 'Deluxe-Valley View';
        var tot_deluxe = $('#deluxe_room').val();
        var total_room_deluxe = parseInt(tot_deluxe) + parseInt(room_no);
        $('#deluxe_room').val(total_room_deluxe);
    }
    hide_input.val(room_no);
    hide_price.val(price);
    element.dataset.toggle = "modal";
    element.dataset.target = "#exampleModalCenter";
    let z = document.getElementById('modal_input');
    if (z) {
        document.getElementById("modal_input").remove();
    }
    let input = document.createElement("INPUT");
    input.setAttribute("type", "hidden");
    var newtype = type.split(" ")
    var len = newtype.length;
    if (newtype.length < 5) {
        input.value = view + " " + newtype[len - 1];
    }
    else {
        input.value = view + " " + newtype[len - 3];
    }
    input.id = "modal_input";
    document.getElementById('modal-body').appendChild(input);
    $('#limit').val(room_no * 4);
    $(".sidebar-card").append(` <div class="selected_room hide" id="${arr[1]}"> <span class="close_btn"><i class="icon-cancel-2" id="select-room-classic-cancel"></i></span> <h4 class="view_find">${new_view}</h4> <span class="adults_2599"></span> <br> <span >Rooms: <span class='room_no'>${room_no}</span></span><br> <span class='type'>${type}</span><br>Adults: <span class="adult_val"></span><br>Kids: <span class="kids_val"></span> <div class="book_price_details"> <h4 class='price'>${price}</h4><h4>/-</h4><span>Per Night</span> </div> </div>`);

}

$("body").on("click", ".icon-cancel-2", function (e) {
    var t_p = $('#total_price').html();
    var t = $(this).parents('.selected_room').attr('id');
    //For room type
    var hide_input = $(`.${t}`).next();
    var hide_price = $(`.${t}`).next().next();
    var hide_adult = $(`.${t}`).next().next().next();
    var hide_kids = $(`.${t}`).next().next().next().next();
    hide_input.val('0');
    hide_price.val('0');
    hide_adult.val('0');
    hide_kids.val('0');
    var removeattribute = $(`.${t}`).parents('.room_rate_select').find('.minus_count');
    $(removeattribute).removeData("toggle");
    $(removeattribute).removeData("target");
    var addremove = $(`.${t}`).parents('.room_rate_select').find('.plus_count');
    $(addremove).removeData("toggle");
    $(addremove).removeData("target");

    var price = $(`#${t}`).find('.price').text();
    t_p = parseInt(t_p) - parseInt(price);
    $('#total_price').html(t_p);
    $('#tp').val(t_p);
    var view = $(`#${t}`).find('.view_find').text();
    var room_no1 = $(`#${t}`).find('.room_no').text();
    total_room = total_room - parseInt(room_no1);
    if (view == 'Classic-Valley View') {
        var tot_classic = $('#classic_room').val();
        var total_room_classic = parseInt(tot_classic) - parseInt(room_no1);
        $('#classic_room').val(total_room_classic);
    }
    if (view == 'Deluxe-Valley View') {
        var tot_deluxe = $('#deluxe_room').val();
        var total_room_deluxe = parseInt(tot_deluxe) - parseInt(room_no1);
        $('#deluxe_room').val(total_room_deluxe);
    }

    $(this).parents('.selected_room').remove();
    disbaledbtn = 0;
    //the above method will remove the user_data div
});


// Minus counter
function minusCounter(element) {
    var count = jQuery(element).parent().find(".no_counter").html();
    var x = jQuery(element).parent().find(".no_counter");
    var arr = x.attr('class').split(' ');
    if (count <= 1) {
        element.removeAttribute('data-toggle');
        element.removeAttribute('data-target');
        return false;
    }
    count--;
    jQuery(element).parent().find(".no_counter").text(count);

    if ($('#sidebar-card').children().length > 0) {
        if ($('#sidebar-card').find(`#${arr[1]}`).length > 0) {

            total_room = total_room - 1;
            var main_price = jQuery(element).parent().parent().parent().find(".room_rate_offe_price").find('.price').html();
            var price = $('#sidebar-card').find(`#${arr[1]}`).find('.price').text();
            $('#sidebar-card').find(`#${arr[1]}`).find('.price').text(price - main_price);
            $('#sidebar-card').find(`#${arr[1]}`).find('.room_no').html(count);

            if (count >= 0) {
                $(`.${arr[1]}`).next().val(count);
                $(`.${arr[1]}`).next().next().val(price - main_price);
            }

            var room_no1 = $('#sidebar-card').find(`#${arr[1]}`).find('.room_no').text();
            var t_p = $('#total_price').html();
            t_p = parseInt(t_p) - parseInt(main_price);
            $('#total_price').html(t_p);
            $('#tp').val(t_p);
            var view = $('#sidebar-card').find(`#${arr[1]}`).find('.view_find').text();
            if (view == 'Classic-Valley View') {
                var tot_classic = $('#classic_room').val();
                var total_room_classic = parseInt(tot_classic) - 1;
                $('#classic_room').val(total_room_classic);
            }
            if (view == 'Deluxe-Valley View') {
                var tot_deluxe = $('#deluxe_room').val();
                var total_room_deluxe = parseInt(tot_deluxe) - 1;
                $('#deluxe_room').val(total_room_deluxe);
            }
            element.dataset.toggle = "modal";
            element.dataset.target = "#exampleModalCenter";
            let limit = count * 4;
            $('#limit').val(limit);
            document.getElementById('member_adults').innerHTML = '<option value="0">--Select Adults--</option>';
            for (i = 0; i < limit - count; i++) {
                document.getElementById('member_adults').innerHTML += `<option value="${i + 1}">${i + 1}</option>`;
            }
            document.getElementById('member_kids').innerHTML = '<option value="0">--Select Kids--</option>';
            for (i = 0; i < limit; i++) {
                document.getElementById('member_kids').innerHTML += `<option value="${i + 1}">${i + 1}</option>`;
            }


        }
        else {
            element.removeAttribute('data-toggle');
            element.removeAttribute('data-target');
        }
    }
}

// Plus counter
function plusCounter(element) {
    var count = jQuery(element).parent().find(".no_counter").text();
    if ($('#sidebar-card').children().length <= 0) {
        count++;
        jQuery(element).parent().find(".no_counter").html(count);
    }
    var x = jQuery(element).parent().find(".no_counter");
    var arr = x.attr('class').split(' ');
    if ($('#sidebar-card').children().length > 0) {
        var room_no1 = $('#sidebar-card').find(`#${arr[1]}`).find('.room_no').text();




        // For increasing mealtype des



        if ($('#sidebar-card').find(`#${arr[1]}`).length > 0) {

            if ((total_room + 1) > change_room) {
                alert(`You have selected only ${change_room} rooms`);
                element.removeAttribute('data-toggle');
                element.removeAttribute('data-target');
                return false;
            }
            else {
                total_room = total_room + 1;
            }
            count++;
            jQuery(element).parent().find(".no_counter").html(count);
            var main_price = jQuery(element).parent().parent().parent().find(".room_rate_offe_price").find('.price').html();
            $('#sidebar-card').find(`#${arr[1]}`).find('.room_no').html(count);
            var price = $('#sidebar-card').find(`#${arr[1]}`).find('.price').text();
            var calc = parseInt(main_price) + parseInt(price);
            $('#sidebar-card').find(`#${arr[1]}`).find('.price').text(calc);
            $(`.${arr[1]}`).next().val(count);
            $(`.${arr[1]}`).next().next().val(parseInt(main_price) + parseInt(price));
            var t_p = $('#total_price').html();
            t_p = parseInt(t_p) + parseInt(main_price);
            $('#total_price').html(t_p);
            $('#tp').val(t_p);
            var view = $('#sidebar-card').find(`#${arr[1]}`).find('.view_find').text();
            if (view == 'Classic-Valley View') {
                var tot_classic = $('#classic_room').val();
                var total_room_classic = parseInt(tot_classic) + 1;
                $('#classic_room').val(total_room_classic);
            }
            if (view == 'Deluxe-Valley View') {
                var tot_deluxe = $('#deluxe_room').val();
                var total_room_deluxe = parseInt(tot_deluxe) + 1;
                $('#deluxe_room').val(total_room_deluxe);
            }

            element.dataset.toggle = "modal";
            element.dataset.target = "#exampleModalCenter";
            let limit = count * 4;
            $('#limit').val(limit);
            document.getElementById('member_adults').innerHTML = '<option value="0">--Select Adults--</option>';
            for (i = 0; i < limit - count; i++) {
                document.getElementById('member_adults').innerHTML += `<option value="${i + 1}">${i + 1}</option>`;
            }
            document.getElementById('member_kids').innerHTML = '<option value="0">--Select Kids--</option>';
            for (i = 0; i < limit; i++) {
                document.getElementById('member_kids').innerHTML += `<option value="${i + 1}">${i + 1}</option>`;
            }
        }
        else {
            element.removeAttribute('data-toggle');
            element.removeAttribute('data-target');
            count++;
            jQuery(element).parent().find(".no_counter").html(count);
        }
    }
}










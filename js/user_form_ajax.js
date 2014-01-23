function update_roles(updateUrl) {
    // reload the role select field
    $.ajax({
        type: 'get',
        url: updateUrl,
        data: {
            "ajax": "1"
        },
        success: function (resp) {
            console.log(resp);
            $("#role_list").replaceWith(resp);
        },
        error: function () {
            alert('update_roles error');
        }
    });
}

function revoke(url, role_name, updateUrl) {
    var role = "#role-" + role_name;
    $.ajax({
        type: 'get',
        url: url,
        success: function (resp) {
            $('li').remove(role);
            update_roles(updateUrl);
        },
        error: function () {
            alert('revoke error');
        }
    });
}

function assign(url, updateUrl) {
    $.ajax({
        type: 'get',
        url: url,
        data: {
            "role": $("#User_role").val(),
            "ajax": "1"
        },
        success: function (resp) {
            console.log(resp);
            $("ul.roles").append(resp);
            update_roles(updateUrl);
        },
        error: function () {
            alert('assign error');
        }
    });
}

const urlBase =
    "https://URL/APPROPRIATEFOLDER";

let userId =
    localStorage.getItem("userId");

document.addEventListener(
    "DOMContentLoaded",
    function()
    {
        document.getElementById(
            "welcome"
        ).innerHTML =
            "Welcome " +
            localStorage.getItem(
                "firstName"
            );

        searchContacts();
    }
);

function logout()
{
    localStorage.clear();

    window.location.href =
        "index.html";
}

function addContact()
{
    let payload =
    {
        userId: userId,

        firstName:
            document.getElementById(
                "newFirstName"
            ).value,

        lastName:
            document.getElementById(
                "newLastName"
            ).value,

        phone:
            document.getElementById(
                "newPhone"
            ).value,

        email:
            document.getElementById(
                "newEmail"
            ).value
    };

    fetch(urlBase + "/AddContact.php",
    {
        method: "POST",

        headers:
        {
            "Content-Type":
                "application/json"
        },

        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data =>
    {
        searchContacts();
    });
}

function searchContacts()
{
    let search =
        document.getElementById(
            "searchText"
        ).value;

    let payload =
    {
        search: search,
        userId: userId
    };

    fetch(urlBase + "/SearchContacts.php",
    {
        method: "POST",

        headers:
        {
            "Content-Type":
                "application/json"
        },

        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data =>
    {
        buildTable(data.results);
    });
}

function editContact(contactId)
{
    let payload =
    {
        id: contactId,

        firstName:
            document.getElementById(
                "first" + contactId
            ).value,

        lastName:
            document.getElementById(
                "last" + contactId
            ).value,

        phone:
            document.getElementById(
                "phone" + contactId
            ).value,

        email:
            document.getElementById(
                "email" + contactId
            ).value
    };

    fetch(urlBase + "/EditContact.php",
    {
        method: "POST",

        headers:
        {
            "Content-Type":
                "application/json"
        },

        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data =>
    {
        alert("Contact Updated");
    });
}

function deleteContact(contactId)
{
    if(!confirm(
        "Delete this contact?"
    ))
    {
        return;
    }

    fetch(urlBase + "/DeleteContact.php",
    {
        method: "POST",

        headers:
        {
            "Content-Type":
                "application/json"
        },

        body: JSON.stringify(
        {
            id: contactId
        })
    })
    .then(response => response.json())
    .then(data =>
    {
        searchContacts();
    });
}

function buildTable(results)
{
    let html = "";

    if(!results ||
       results.length === 0)
    {
        html =
        `
        <tr>
            <td colspan="5">
                No Contacts Found
            </td>
        </tr>
        `;

        document.getElementById(
            "contactTable"
        ).innerHTML = html;

        return;
    }

    for(let i = 0;
        i < results.length;
        i++)
    {
        html +=
        `
        <tr>

            <td>
                <input
                    id="first${results[i].id}"
                    value="${results[i].firstName}">
            </td>

            <td>
                <input
                    id="last${results[i].id}"
                    value="${results[i].lastName}">
            </td>

            <td>
                <input
                    id="phone${results[i].id}"
                    value="${results[i].phone}">
            </td>

            <td>
                <input
                    id="email${results[i].id}"
                    value="${results[i].email}">
            </td>

            <td>

                <button
                    onclick="editContact(${results[i].id})">
                    Save
                </button>

                <button
                    onclick="deleteContact(${results[i].id})">
                    Delete
                </button>

            </td>

        </tr>
        `;
    }

    document.getElementById(
        "contactTable"
    ).innerHTML = html;
}
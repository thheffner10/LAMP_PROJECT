const urlBase =
    "https://URL/APPROPRIATEFOLDER";

function doLogin()
{
    let login =
        document.getElementById(
            "loginName"
        ).value;

    let password =
        document.getElementById(
            "loginPassword"
        ).value;

    let payload =
    {
        login: login,
        password: password
    };

    fetch(urlBase + "/Login.php",
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
        if(data.id > 0)
        {
            localStorage.setItem(
                "userId",
                data.id
            );

            localStorage.setItem(
                "firstName",
                data.firstName
            );

            window.location.href =
                "contacts.html";
        }
        else
        {
            document.getElementById(
                "loginResult"
            ).innerHTML =
                "Invalid Username/Password";
        }
    })
    .catch(error =>
    {
        console.log(error);
    });
}
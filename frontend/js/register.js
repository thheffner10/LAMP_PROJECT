const urlBase =
    "https://URL/APPROPRIATEFOLDER";

function doRegister()
{
    let payload =
    {
        firstName:
            document.getElementById(
                "firstName"
            ).value,

        lastName:
            document.getElementById(
                "lastName"
            ).value,

        login:
            document.getElementById(
                "username"
            ).value,

        password:
            document.getElementById(
                "password"
            ).value
    };

    fetch(urlBase + "/Register.php",
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
        document.getElementById(
            "registerResult"
        ).innerHTML =
            "Account Created Successfully";
    })
    .catch(error =>
    {
        console.log(error);
    });
}
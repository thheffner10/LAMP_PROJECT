const urlBase =
    "https://tncis4004.xyz/LAMPAPI";

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
        username: login,
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
        if(data.success)
        {
            localStorage.setItem(
                "userId",
                data.user.user_ID
            );

            localStorage.setItem(
                "firstName",
                data.user.firstName
            );

            window.location.href =
                "contacts.html";
        }
        else
        {
            document.getElementById(
                "loginResult"
            ).innerHTML =
                data.message;
        }
    })
    .catch(error =>
    {
        console.log(error);
    });
}

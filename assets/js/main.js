

async function logMovies() {
    const databaseId = "8b7bb9a6068647e88cd5cb16ffc01848?v=be8f604f39184e3aaa989cc7c618724d";

    const url = "https://api.notion.com/v1/databases/" + databaseId

    try {
        const response = await fetch(url, {
            method: "GET",
            headers: {
                "Authorization": "Bearer 'secret_uPBBR6snphU8rKertMWty82DqrUNgGcVe4PJf5fCCSi'",
                "Notion-Version": "2021-08-16",
            },
        });

        const movies = await response.json();
        console.log(movies);
    } catch (error) {
        console.log(error)
    }

}
logMovies().then((response) => console.log(response)).catch((e) => console.log(e))


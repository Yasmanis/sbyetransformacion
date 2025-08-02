export const allDefaultProviders = [
    {
        name: "youtube",
        url: /^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=|embed\/|v\/|shorts\/)?([a-zA-Z0-9_-]{11})/,
        html: (match) =>
            `<iframe src="https://www.youtube.com/embed/${match[1]}" frameborder="0" allowfullscreen></iframe>`,
    },
    {
        name: "vimeo",
        url: /^https?:\/\/(?:www\.|player\.)?vimeo\.com\/(?:video\/)?(\d+)/,
        html: (match) =>
            `<iframe src="https://player.vimeo.com/video/${match[1]}" frameborder="0" allowfullscreen></iframe>`,
    },
    {
        name: "dailymotion",
        url: /^https?:\/\/(?:www\.)?dailymotion\.com\/video\/([a-zA-Z0-9]+)/,
        html: (match) =>
            `<iframe src="https://www.dailymotion.com/embed/video/${match[1]}" frameborder="0" allowfullscreen></iframe>`,
    },
    {
        name: "spotify",
        url: /^https?:\/\/open\.spotify\.com\/(track|album|playlist)\/([a-zA-Z0-9]+)/,
        html: (match) =>
            `<iframe src="https://open.spotify.com/embed/${match[1]}/${match[2]}" width="300" height="380" frameborder="0"></iframe>`,
    },
];

export const localProviders = [
    {
        name: "localServer",
        url: /^(https?:\/\/[^\/]+\/)?shared-file\/[a-zA-Z0-9=]+$/,
        html: (match) => {
            return `
                  <video controls width="100%">
                    <source src="${match[0]}/1">
                    Tu navegador no soporta el elemento de video.
                  </video>
                `;
        },
    },
];

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".post-body-wrapper pre").forEach((preTag) => {
        // Create a new div element
        const wrapperDiv = document.createElement("div");
        const codeTag = document.createElement("code");

        // Wrap the pre element with the new div
        preTag.parentNode.insertBefore(wrapperDiv, preTag);
        wrapperDiv.appendChild(preTag);
        wrapperDiv.classList.add("hljs-container");
        wrapperDiv.style.position = "relative";

        const button = document.createElement("button");
        button.className = "copy-btn";
        button.dataset.copied = false;

        button.addEventListener("click", () => {
            const code = wrapperDiv.querySelector("pre code").textContent;
            navigator.clipboard.writeText(code).then(() => {
                button.dataset.copied = true;
                setTimeout(() => {
                    button.dataset.copied = false;
                }, 2000);
            });
        });
        wrapperDiv.appendChild(button);

        const code = preTag.innerText;
        codeTag.innerText = code;
        preTag.innerText = "";

        preTag.appendChild(codeTag);

        const content = codeTag.innerText.split("```\n");

        if (content.length === 2) {
            const highlighted = hljs.highlight(content[1], {
                language: content[0].replace("```", ""),
            });

            codeTag.innerHTML = highlighted.value;
        } else {
            const highlighted = hljs.highlightAuto(codeTag.innerText);

            codeTag.innerHTML = highlighted.value;
        }
    });

    document.querySelectorAll(".post-body-wrapper a").forEach((anchor) => {
        anchor.setAttribute("target", "_blank");
    });
});

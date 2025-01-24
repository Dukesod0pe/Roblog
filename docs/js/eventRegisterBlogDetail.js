const commentLimit = 1000;
updateCharacterCount(document.getElementById('commentInput'), document.getElementById('commentCounter'), commentLimit);

let voteForm = document.getElementById("voteForm");
voteForm.addEventListener("click", registerVote);

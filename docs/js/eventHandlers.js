function validateName_T(name) {
	let nameRegEx = /^[a-zA-Z]+$/;

	if (nameRegEx.test(name))
		return true;
	else
		return false;
}

function validateDOB_T(dob) {
	let dobRegEx = /^\d{4}[-]\d{2}[-]\d{2}$/;

	if (dobRegEx.test(dob))
		return true;
	else
		return false;
}

function validateEmail_T(email) {
	let emailRegEx = /^[a-zA-Z]{3}\d{3}@uregina.ca$/;

	if (emailRegEx.test(email))
		return true;
	else
		return false;
}

function validateUsername_T(username) {
	let usernameRegEx = /^[a-zA-Z]+$/;

	if (usernameRegEx.test(username))
		return true;
	else
		return false;
}

function validatePWD_T(pwd) {
	let pwdRegEx = /^\S+[^a-zA-Z ]+\S+$/;

	if (pwdRegEx.test(pwd) && pwd.length >= 6)
		return true;
	else
		return false;
}

function validateAvatar_T(avatar) {
	let avatarRegEx = /^[^\n]+\.[a-zA-Z]{3,4}$/;

	if (avatarRegEx.test(avatar))
		return true;
	else
		return false;
}


function validateLogin_T(event) {

	let email = document.getElementById("email_T");
	let emailError = document.getElementById("error-text-email_T");

	let password = document.getElementById("password_T");
	let passwordError = document.getElementById("error-text-password_T");

	let formIsValid = true;

	if (!validateEmail_T(email.value)) {
		email.classList.add("invalid-box_T");
		emailError.classList.remove("error-text-hidden");
		emailError.classList.add("invalid-text_T");

		formIsValid = false;
	}
	else {
		email.classList.remove("invalid-box_T");
		emailError.classList.add("error-text-hidden");
	}

	if (!validatePWD_T(password.value)) {
		password.classList.add("invalid-box_T");
		passwordError.classList.remove("error-text-hidden");
		passwordError.classList.add("invalid-text_T");

		formIsValid = false;
	}
	else {
		password.classList.remove("invalid-box_T");
		passwordError.classList.add("error-text-hidden");
	}


	if (formIsValid === false) {
		event.preventDefault();

	}
	else {
		console.log("Validation successful, sending data to the server");
	}
}

function fNameHandler_T(event) {
	let fname = event.target;
	let fnameError = document.getElementById("error-text-fname_T");

	if (!validateName_T(fname.value)) {
		fname.classList.add("invalid-box_T");
		fnameError.classList.remove("error-text-hidden");
		fnameError.classList.add("invalid-text_T");

	}
	else {
		fname.classList.remove("invalid-box_T");
		fnameError.classList.add("error-text-hidden");
	}
}

function lNameHandler_T(event) {
	let lname = event.target;
	let lnameError = document.getElementById("error-text-lname_T");

	if (!validateName_T(lname.value)) {
		lname.classList.add("invalid-box_T");
		lnameError.classList.remove("error-text-hidden");
		lnameError.classList.add("invalid-text_T");

	}
	else {
		lname.classList.remove("invalid-box_T");
		lnameError.classList.add("error-text-hidden");
	}
}

function dobHandler_T(event) {
	let dob = event.target;
	let dobError = document.getElementById("error-text-dob_T");

	if (!validateDOB_T(dob.value)) {
		dob.classList.add("invalid-box_T");
		dobError.classList.remove("error-text-hidden");
		dobError.classList.add("invalid-text_T");
	}
	else {
		dob.classList.remove("invalid-box_T");
		dobError.classList.add("error-text-hidden");
	}
}

function emailHandler_T(event) {
	let email = event.target;
	let emailError = document.getElementById("error-text-email_T");

	if (!validateEmail_T(email.value)) {
		email.classList.add("invalid-box_T");
		emailError.classList.remove("error-text-hidden");
		emailError.classList.add("invalid-text_T");

	}
	else {
		email.classList.remove("invalid-box_T");
		emailError.classList.add("error-text-hidden");
	}
}

function unameHandler_T(event) {
	let uname = event.target;
	let unameError = document.getElementById("error-text-uname_T");

	if (!validateUsername_T(uname.value)) {
		uname.classList.add("invalid-box_T");
		unameError.classList.remove("error-text-hidden");
		unameError.classList.add("invalid-text_T");

	}
	else {
		uname.classList.remove("invalid-box_T");
		unameError.classList.add("error-text-hidden");
	}
}

function pwdHandler_T(event) {
	let pwd = event.target;
	let pwdError = document.getElementById("error-text-pwd_T");

	if (!validatePWD_T(pwd.value)) {
		pwd.classList.add("invalid-box_T");
		pwdError.classList.remove("error-text-hidden");
		pwdError.classList.add("invalid-text_T");

	}
	else {
		pwd.classList.remove("invalid-box_T");
		pwdError.classList.add("error-text-hidden");
	}
}

function cpwdHandler_T(event) {
	let pwd = document.getElementById("pwd_T");
	let cpwd = event.target;
	let cpwdError = document.getElementById("error-text-confirmpwd_T");
	if (pwd.value !== cpwd.value) {
		cpwd.classList.add("invalid-box_T");
		cpwdError.classList.remove("error-text-hidden");
		cpwdError.classList.add("invalid-text_T");
	}
	else {
		cpwd.classList.remove("invalid-box_T");
		cpwdError.classList.add("error-text-hidden");
	}
}

function avatarHandler_T(event) {
	let avatar = event.target;
	let avatarError = document.getElementById("error-text-pfp_T");
	if (!validateAvatar_T(avatar.value)) {
		avatar.classList.add("invalid-box_T");
		avatarError.classList.remove("error-text-hidden");
		avatarError.classList.add("invalid-text_T");
	}
	else {
		avatar.classList.remove("invalid-box_T");
		avatarError.classList.add("error-text-hidden");
	}
}

function validateSignup_T(event) {

	let fname = document.getElementById("fname_T");
	let fnameError = document.getElementById("error-text-fname_T");

	let lname = document.getElementById("lname_T");
	let lnameError = document.getElementById("error-text-lname_T");

	let dob = document.getElementById("dob_T");
	let dobError = document.getElementById("error-text-dob_T");

	let email = document.getElementById("email_T");
	let emailError = document.getElementById("error-text-email_T");

	let uname = document.getElementById("uname_T");
	let unameError = document.getElementById("error-text-uname_T");

	let pwd = document.getElementById("pwd_T");
	let pwdError = document.getElementById("error-text-pwd_T");

	let cpwd = document.getElementById("confirmpwd_T");
	let cpwdError = document.getElementById("error-text-confirmpwd_T");

	let avatar = document.getElementById("pfp_T");
	let avatarError = document.getElementById("error-text-pfp_T");

	let formIsValid = true;

	if (!validateName_T(fname.value)) {
		fname.classList.add("invalid-box_T");
		fnameError.classList.remove("error-text-hidden");
		fnameError.classList.add("invalid-text_T");

		formIsValid = false;
	}
	else {
		fname.classList.remove("invalid-box_T");
		fnameError.classList.add("error-text-hidden");
	}

	if (!validateName_T(lname.value)) {
		lname.classList.add("invalid-box_T");
		lnameError.classList.remove("error-text-hidden");
		lnameError.classList.add("invalid-text_T");

		formIsValid = false;
	}
	else {
		lname.classList.remove("invalid-box_T");
		lnameError.classList.add("error-text-hidden");
	}

	if (!validateDOB_T(dob.value)) {
		dob.classList.add("invalid-box_T");
		dobError.classList.remove("error-text-hidden");
		dobError.classList.add("invalid-text_T");

		formIsValid = false;
	}
	else {
		dob.classList.remove("invalid-box_T");
		dobError.classList.add("error-text-hidden");
	}

	if (!validateEmail_T(email.value)) {
		email.classList.add("invalid-box_T");
		emailError.classList.remove("error-text-hidden");
		emailError.classList.add("invalid-text_T");

		formIsValid = false;
	}
	else {
		email.classList.remove("invalid-box_T");
		emailError.classList.add("error-text-hidden");
	}

	if (!validateUsername_T(uname.value)) {
		uname.classList.add("invalid-box_T");
		unameError.classList.remove("error-text-hidden");
		unameError.classList.add("invalid-text_T");

		formIsValid = false;
	}
	else {
		uname.classList.remove("invalid-box_T");
		unameError.classList.add("error-text-hidden");
	}

	if (!validatePWD_T(pwd.value)) {
		pwd.classList.add("invalid-box_T");
		pwdError.classList.remove("error-text-hidden");
		pwdError.classList.add("invalid-text_T");

		formIsValid = false;
	}
	else {
		pwd.classList.remove("invalid-box_T");
		pwdError.classList.add("error-text-hidden");
	}

	if (pwd.value != cpwd.value) {
		cpwd.classList.add("invalid-box_T");
		cpwdError.classList.remove("error-text-hidden");
		cpwdError.classList.add("invalid-text_T");

		formIsValid = false;
	} 
	else {
		cpwd.classList.remove("invalid-box_T");
		cpwdError.classList.add("error-text-hidden");
	}

	if (!validateAvatar_T(avatar.value)) {
		avatar.classList.add("invalid-box_T");
		avatarError.classList.remove("error-text-hidden");
		avatarError.classList.add("invalid-text_T");

		formIsValid = false;
	} 
	else {
		avatar.classList.remove("invalid-box_T");
		avatarError.classList.add("error-text-hidden");
	}

	if (formIsValid === false) {
		event.preventDefault();
	}
	else {
		console.log("validation successful, sending data to the server");
	}
}

function updateCharacterCount(inputField, displayElement, limit) {
    inputField.addEventListener('input', () => {
        const currentLength = inputField.value.length;
        const remaining = limit - currentLength;
        
        if (remaining >= 0) {
            displayElement.textContent = `${remaining} characters left`;
            displayElement.classList.remove('exceeded');
        } else {
            displayElement.textContent = `Exceeded by ${-remaining} characters`;
            displayElement.classList.add('exceeded');
        }
    });
}

function registerVote(event) {
    if (event.target.closest(".submitVote")) {
        let button = event.target.closest(".submitVote");
        let voteType = button.dataset.voteType;
        let commentId = button.dataset.commentId;

        let userId = document.getElementById("user_id").value;
        let blogId = document.getElementById("blog_id").value;

        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                if (response.success) {
                    let counter = document.getElementById("counter-" + commentId);
                    if (counter) {
                        counter.textContent = response.newVoteCount;
                    }
                } else {
                    console.log("Error processing vote");
                }
            }
        };
        xhr.open("GET", "voteHandler.php?blog_id=" + blogId + "&user_id=" + userId + "&comment_id=" + commentId + "&voteType=" + voteType, true);
        xhr.send();
    }
}

let recentBlogId = 0; 
let maxBlogs = 20;

function updateBlogs() {
    let xhr = new XMLHttpRequest();
	 
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);
            
            if (response.success && response.blogs.length > 0) {
				let blogContainer = document.getElementById("blog");
            
                for (let i = 0; i < response.blogs.length; i++) {
					let blog = response.blogs[i];
					let blogElement = createBlogElement(blog); 
					blogContainer.prepend(blogElement); 
				}

                recentBlogId = response.blogs[0].blog_id;

                while (blogContainer.children.length > maxBlogs) {
                    blogContainer.lastElementChild.remove();
                }
            } else {
				console.log("An Error has occurred");
			}
        }
    }
    xhr.open("GET", "blogHandler.php?recentBlogId=" + recentBlogId, true);
    xhr.send();
}

function createBlogElement(blog) {
	let blogId = blog.blog_id;
    let blogLink = document.createElement("a");
    blogLink.href = "blogDetails.php?blog_id=" + blogId;

    let blogButton = document.createElement("button");

    let avatarImg = document.createElement("img");
    avatarImg.className = "avatar";
    avatarImg.src = blog.avatar;
    avatarImg.alt = "avatar";
    blogButton.appendChild(avatarImg);

    let usernameDiv = document.createElement("div");
    let usernameH2 = document.createElement("h2");
    usernameH2.className = "name";
    usernameH2.textContent = blog.username;
    usernameDiv.appendChild(usernameH2);
    blogButton.appendChild(usernameDiv);

    let dateTimeDiv = document.createElement("div");
    let dateTimeP = document.createElement("p");
    dateTimeP.textContent = blog.date_time;
    dateTimeDiv.appendChild(dateTimeP);
    blogButton.appendChild(dateTimeDiv);

    blogButton.appendChild(document.createElement("br"));

    let imageDiv = document.createElement("div");
    imageDiv.className = "image_D";
    let featuredImg = document.createElement("img");
    featuredImg.src = blog.featured_image;
    featuredImg.alt = "image";
    imageDiv.appendChild(featuredImg);
    blogButton.appendChild(imageDiv);

    blogButton.appendChild(document.createElement("br"));

    let titleH3 = document.createElement("h3");
    titleH3.className = "title_D";
    titleH3.textContent = blog.blog_content_preview + "...";
    blogButton.appendChild(titleH3);

    let contentDiv = document.createElement("div");
    contentDiv.className = "content_D";
    let commentsP = document.createElement("p");
    commentsP.textContent = "Total Comments = " + blog.comment_count;
    contentDiv.appendChild(commentsP);
    blogButton.appendChild(contentDiv);

    blogLink.appendChild(blogButton);

    return blogLink;
}

setInterval(updateBlogs, 120000);

let recentCommentId = 0;

function updateComments() {
    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);
            
            if (response.success && response.comments.length > 0) {
                
                let commentContainer = document.getElementById("commentSection_G");
                
                for (let i = 0; i < response.comments.length; i++) {
                    let comment = response.comments[i];
                    let commentElement = createCommentElement(comment); 
                    commentContainer.append(commentElement); 
                }

                recentCommentId = response.comments[0].comment_id;

            } else {
				console.log("An Error has occurred");
			}
        }
    };

    xhr.open("GET", "detailsManager.php?recentCommentId=" + recentCommentId, true);
    xhr.send();
}

function createCommentElement(comment) {
    let commentDiv = document.createElement("div");
    commentDiv.classList.add("comment_G");

    let img = document.createElement("img");
    img.src = comment.comment_avatar;
    img.alt = comment.comment_avatar;

    commentDiv.appendChild(img);

    let commentDetails = document.createElement("div");
    commentDetails.classList.add("comment-details_G");

    let authorSpan = document.createElement("span");
    authorSpan.classList.add("comment-author_G");
    authorSpan.textContent = comment.username;
    commentDetails.appendChild(authorSpan);

    let commentBody = document.createElement("p");
    commentBody.classList.add("comment-text_G");
    commentBody.textContent = comment.Body;
    commentDetails.appendChild(commentBody);

    let voteForm = document.createElement("form");
    voteForm.classList.add("comment-votes_G");
    voteForm.setAttribute("action", "");
    voteForm.setAttribute("method", "get");
    voteForm.id = "voteForm";

    let userIdInput = document.createElement("input");
    userIdInput.type = "hidden";
    userIdInput.id = "user_id";
    userIdInput.name = "user_id";
    userIdInput.value = comment.user_id;

    let commentIdInput = document.createElement("input");
    commentIdInput.type = "hidden";
    commentIdInput.id = "comment_id";
    commentIdInput.name = "comment_id";
    commentIdInput.value = comment.comment_id;

    let blogIdInput = document.createElement("input");
    blogIdInput.type = "hidden";
    blogIdInput.id = "blog_id";
    blogIdInput.name = "blog_id";
    blogIdInput.value = comment.blog_id;

    voteForm.appendChild(userIdInput);
    voteForm.appendChild(commentIdInput);
    voteForm.appendChild(blogIdInput);

    let upvoteButton = document.createElement("button");
    upvoteButton.type = "button";
    upvoteButton.classList.add("submitVote");
    upvoteButton.setAttribute("data-comment-id", comment.comment_id);
    upvoteButton.setAttribute("data-vote-type", "upvote");

    let upvoteImage = document.createElement("span");
    upvoteImage.classList.add("vote_G");

    let upvoteImg = document.createElement("img");
    upvoteImg.src = "img/UPVOTE_ON.png";
    upvoteImage.appendChild(upvoteImg);

    upvoteButton.appendChild(upvoteImage);
    voteForm.appendChild(upvoteButton);

    let counterDiv = document.createElement("div");
    counterDiv.id = "counter-" + comment.comment_id;
    counterDiv.textContent = comment.NumVotes;
    voteForm.appendChild(counterDiv);

    let downvoteButton = document.createElement("button");
    downvoteButton.type = "button";
    downvoteButton.classList.add("submitVote");
    downvoteButton.setAttribute("data-comment-id", comment.comment_id);
    downvoteButton.setAttribute("data-vote-type", "downvote");

    let downvoteImage = document.createElement("span");
    downvoteImage.classList.add("vote_G");

    let downvoteImg = document.createElement("img");
    downvoteImg.src = "img/DOWNVOTE_ON.png";
    downvoteImage.appendChild(downvoteImg);

    downvoteButton.appendChild(downvoteImage);
    voteForm.appendChild(downvoteButton);

    commentDetails.appendChild(voteForm);

    commentDiv.appendChild(commentDetails);

    return commentDiv;
}

setInterval(updateComments, 120000);

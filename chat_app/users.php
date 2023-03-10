<?php

// http://localhost/practice-php/php-lab/apps/chat_app

session_start();

require_once("classes/UserLogic.php");
require_once('php/config.php');

if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
}

$user = UserLogic::getUserFromId($_SESSION['unique_id']);
$stmt = UserLogic::fetchAllUsers();

foreach($stmt as $row){
    if($row['unique_id'] !== $_SESSION['unique_id']){
        $user_array[] = $row;
    }
}
$param_json = json_encode($user_array);

?>

<!DOCTYPE html>
<html lang="en">
<?php include_once('./head.php') ?>
<body>
    <div class="wrapper">
        <section class="users">
            <header>
                <div class="content">
                    <img src="./images/<?php echo($user['img']) ?>" alt="">
                    <div class="details">
                        <span><?php echo($user['lname'].' '.$user['fname']) ?></span>
                        <p><?php echo($user['status']) ?></p>
                    </div>
                </div>
                <a href="#" class="logout">Logout</a>
            </header>
            <div class="search">
                <span class="text">Select an user to start chat</span>
                <input
                    type="text"
                    placeholder="Enter name to search..."
                >
                <button>
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <div class="search_users_list"></div>
            <div class="users_list">
                <?php foreach($user_array as $row) : ?>
                    <a href="chat.php?user_id=<?php echo $row['unique_id'] ?>"> 
                        <div class="content">
                            <img src="./images/<?php echo $row['img'] ?>" alt="">
                            <div class="details">
                                <span><?php echo($row['lname'].' '.$row['fname']) ?></span>
                                <p>This is test message</p>
                            </div>
                        </div>
                        <div class="status-dot">
                            <i class="fas fa-circle"></i>
                        </div>
                    </a>
                <?php endforeach; ?>                    
             </div>
        </section>
    </div>

    <script type="text/javascript" defer>
        const searchBar = document.querySelector(".search input")
        const searchIcon = document.querySelector(".search button")
        const usersList = document.querySelector(".users_list")
        const searchUsersList = document.querySelector(".search_users_list")
        // php?????????JSON????????????????????????????????????????????????????????????
        const users_data = JSON.parse('<?php echo $param_json; ?>')
        // SearchBar???????????????
        let serachBar_status = false;
        // ?????????????????????????????????????????????????????????
        let matchedUsers = []

        // searchIcon?????????????????????
        // serach users list????????????user list???????????????????????????????????????????????????
        const initSearchUsersList = () => {
            for(let i=0; i < users_data.length;i++){
                searchUsersList.insertAdjacentHTML('afterbegin', createUserElement(users_data[i]));
            }
        }

        // serach users list???????????????
        const removeAllChildfromSearchUsersList = () => {
            while(searchUsersList.firstChild ){
                searchUsersList.removeChild( searchUsersList.firstChild );
            }
        }

        searchIcon.onclick = () => {
            searchBar.classList.toggle("show");
            searchIcon.classList.toggle("active");
            searchBar.focus();

            serachBar_status = false;
            usersList.style.display = "block";

            // serach users list???????????????
            removeAllChildfromSearchUsersList()

            if(searchBar.classList.contains("show")){
                // .seacrh_users_list????????????????????????(users data)
                initSearchUsersList()

                searchBar.value = "";
                serachBar_status = true
                usersList.style.display = "none";
            }
        }

        // ??????????????????????????????
        const createUserElement = (userData) => {
            return `
                <a href=chat.php?user_id=${userData.unique_id}> 
                    <div class="content">
                        <img src="./images/${userData.img}" alt="">
                        <div class="details">
                            <span>${userData.lname} ${userData.fname}</span>
                            <p>This is test message</p>
                        </div>
                    </div>
                    <div class="status-dot">
                        <i class="fas fa-circle"></i>
                    </div>
                </a>`
        }

        searchBar.onkeyup = (e) => {
            const text = e.target.value
            if(text === "" && serachBar_status) {
                removeAllChildfromSearchUsersList()
                initSearchUsersList()
                return;
            }

            // key???????????????????????????,
            // search users list???????????????
            removeAllChildfromSearchUsersList()
            
            // text????????????????????????????????????????????????????????????
            matchedUsers = users_data.filter(user => {
                const usernameStr = user.fname + user.lname;

                const resultIndex = usernameStr.indexOf(text)

                if(resultIndex !== -1) return user
            })

            // ????????????????????????????????????????????????UI
            if(serachBar_status && matchedUsers.length === 0){
                searchUsersList.insertAdjacentHTML('afterbegin', '<p>???????????????????????????????????????</p>');
            }

            // ???????????????????????????????????????????????????????????????
            if(serachBar_status && matchedUsers.length > 0){
                for(let i=0; i < matchedUsers.length;i++){
                    searchUsersList.insertAdjacentHTML('afterbegin', createUserElement(matchedUsers[i]));
                }
            }
        }
    </script>
</body>
</html>
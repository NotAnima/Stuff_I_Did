#!/bin/bash
# declare STRING variable
STRING="HELLO WORLD!!!"
# print variable on a screen
echo $STRING

KERNEL_FILE=/home/user/linux/CSC1107OS/project/CSC1107OS/CSC1107_Group_03_kernel.c
USER_SPACE_FILE=/home/user/linux/CSC1107OS/project/CSC1107OS/CSC1107_Group_03_user.c
MAKEFILE=/home/user/linux/CSC1107OS/project/CSC1107OS/MakeFile


function logged_in_user() {
    echo "Logged in as: $(whoami)"
    echo "Current Directory: $(pwd)"

    echo "Created a new user"
    echo "$(sudo useradd CSC1107_Group_03)"

    echo "$(sudo usermod --shell /bin/bash CSC1107_Group_03)"
    echo "$(grep CSC1107_Group_03 /etc/passwd)"
}

function user_directory() {
    DIR=/home/user/CSC1107_Group_03
    if [ -d "$DIR" ];
    then
        echo "$DIR directory exists"
        echo "$(rm -rf $DIR)"
    else
        echo "$DIR directory does not exist."
        echo $(mkdir $DIR)
    fi

    echo "$(cd /home/user/CSC1107_Group_03)"
    echo "$(cp $KERNEL_FILE $USER_SPACE_FILE $MAKEFILE .)"

    # Add code for Question 9 to compile loadable kernel module using MakeFile utility

    echo "$(ls -l)"
    
    # Add code to insert compiled loadable kernel into Linux kernel


}

# logged_in_user
user_directory
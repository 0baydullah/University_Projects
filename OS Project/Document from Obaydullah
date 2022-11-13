#! /bin/bash

#GLOBAL VARIABLES
$STUDENT_ID
$PASSWORD
$STUDENT_NAME
$IS_LOGGED_IN
RETURN_URL="unset"

#color variables
bold=$(echo -en "\e[1m")
underline=$(echo -en "\e[4m")

blink=$(echo -en "\e[5m")

normal=$(echo -en "\e[0m")

red=$(echo -en "\e[31m")
green=$(echo -en "\e[32m")
blue=$(echo -en "\e[34m")
aqua=$(echo -en "\e[36m")

white=$(echo -en "\e[97m")
RED=$(echo -en "\e[41m")
GREEN=$(echo -en "\e[42m")
BLUE=$(echo -en "\e[44m")

playground() {
    echo $bold $green RED $GREEN$white\This is black with red background $underline\this is underlined$normal\normal
}

#------------------------------------------------
#Utility Functions
#------------------------------------------------

installDependencies() {
    wget -O htmlq.tar.gz https://github.com/mgdm/htmlq/releases/latest/download/htmlq-x86_64-linux.tar.gz
    sudo tar xf htmlq.tar.gz -C /usr/local/bin
    htmlq --version
}
#text file read
readTextFile() {
    input=./$1
    while IFS= read -r line; do
        echo "$line"
    done <"$input"
}

#search faculty profile
searchFacProfile() {

    #if faculty profile link not exist then generate it first
    fac_link=./fac_link.txt
    if test -f "$fac_link"; then
        echo -e "\nFaculty link generated...."
    else
        fetch_complete=0
        for ((i = 1; i <= 7; i++)); do
            if (($i == 1)); then
                curl -s https://green.edu.bd/faculty-profile-dept/dept-of-cse/ | htmlq --pretty '.profile-faculty' a -a href | uniq >>fac_link.txt
                echo "Fetching..."
            else
                curl -s https://green.edu.bd/faculty-profile-dept/dept-of-cse/page/$i | htmlq --pretty '.profile-faculty' a -a href | uniq >>fac_link.txt
                echo "Fetching...."
            fi
        done
    fi

}

genarateShortNameList() {
    #if shortlist not exist then generate it first
    shortList=./shortList.txt
    if test -f "$shortList"; then
        echo -e '\n'
        read -p 'In your machine shortlist already exists! Want to read? [y/n]' ans
        if [ "$ans" == "Y" ] || [ "$ans" == "y" ]; then
            readTextFile "shortList.txt"
        fi
    else
        echo -e "\nPlease Wait...Working on generating short list....\n"
        for ((i = 1; i <= 7; i++)); do
            if (($i == 1)); then
                curl -s https://green.edu.bd/faculty-profile-dept/dept-of-cse/ | htmlq '.faculty-profile' div '.title' --text >>fac.html
            else
                curl -s https://green.edu.bd/faculty-profile-dept/dept-of-cse/page/$i | htmlq '.faculty-profile' div '.title' --text >>fac.html
                echo "Fetching.."
            fi

            input="./fac.html"
            while IFS= read -r line; do
                echo -n "$line = " >>shortList.txt
                for word in $line; do
                    if [[ $word == "Prof." || $word == "Dr." || $word == "Ms." || $word == "Mr." ]]; then
                        continue
                    fi
                    echo -n "${word:0:1}" >>shortList.txt
                done

                echo -e >>shortList.txt
            done <"$input"

            rm ./fac.html
        done
    fi

}

#search by short name of a teacher and can be extract all the information about their
searchByShortName() {
    read -p "Enter the short form: " name

    #if shortlist not exist then generate it first
    shortList=./shortList.txt
    if test -f "$shortList"; then
        line_num=$(grep -n -w "$name" shortList.txt | tr -dc '0-9')
    else
        genarateShortNameList
        line_num=$(grep -n -w "$name" shortList.txt | tr -dc '0-9')
    fi

    #generate faculty profile link
    link=null
    FILE=./fac_link.txt

    if test -f "$FILE"; then
        link=$(sed -n $line_num"p" fac_link.txt)
    else
        echo -e "\nFac link not exists"
        echo -e "\nPlease Wait! Fething faculty profile..."
        searchFacProfile
        link=$(sed -n $line_num"p" fac_link.txt)
    fi
    full_name=$(sed -n $line_num"p" shortList.txt | cut -f1 -d"=")
    echo -e "\n---------------------------------------------"
    echo -e "\nFull Name: $BLUE$white $full_name $normal"
    echo "Profile Link is: $link"

    #teachers profile download locally if not exists
    checkTeacherProfileLocally="./assets/teachers/$name.html"
    if test -f "$checkTeacherProfileLocally"; then
        echo "All the file belongs to $full_name are already downloaded in your machine"
    else
        curl -s $link >>./assets/teachers/$name.html
        echo "All the info belongs to $full_name is downloaded :)) happy scraping !"
    fi
    echo -e "\n----------------------------------------------\n"

    #------------------------------------------------
    #teachers info menu
    #------------------------------------------------
    while [ "$choose_option" != 6 ]; do
        echo -e "\nDo you want to know more about $green $full_name $normal?"
        echo "[1]-Education"
        echo "[2]-Experience"
        echo "[3]-Publication"
        echo "[4]-Research"
        echo "[5]-Back to Teachers Portal"

        read choose_option

        if [ "$choose_option" == 1 ]; then
            echo "Education Qualification:"
            echo -e "-------------------------\n\n"

            if test -f "$checkTeacherProfileLocally"; then
                htmlq -p ".tab-content #tab-education" -t -w <"$checkTeacherProfileLocally" >>edu.txt
            else
                curl $link | htmlq -p ".tab-content #tab-education" -t -w >>edu.txt
            fi

            readTextFile "edu.txt"
            rm ./edu.txt

        elif [ "$choose_option" == 2 ]; then
            echo "Experinces"
            echo -e "-------------------------\n\n"

            if test -f "$checkTeacherProfileLocally"; then
                htmlq -p ".tab-content #tab-experience" -t -w <"$checkTeacherProfileLocally" >>exp.txt
            else
                curl $link | htmlq -p ".tab-content #tab-experience" -t -w >>exp.txt
            fi

            readTextFile "exp.txt"
            rm ./exp.txt

        elif [ "$choose_option" == 3 ]; then
            echo "Publications"
            echo -e "-------------------------\n\n"

            if test -f "$checkTeacherProfileLocally"; then
                htmlq -p ".tab-content #tab-publications" -t -w <"$checkTeacherProfileLocally" >>pub.txt
            else
                curl $link | htmlq -p ".tab-content #tab-publications" -t -w >>pub.txt
            fi

            readTextFile "pub.txt"
            rm ./pub.txt

        #reasearch option starts here
        elif [ "$choose_option" == 4 ]; then
            echo "Research"
            echo -e "-------------------------\n\n"

            if test -f "$checkTeacherProfileLocally"; then
                htmlq -p ".tab-content #tab-research" -t -w <"$checkTeacherProfileLocally" >>res.txt
            else
                curl $link | htmlq -p ".tab-content #tab-research" -t -w >>res.txt
            fi

            readTextFile "res.txt"
            rm ./res.txt
        #reasearch option starts here

        elif [ "$choose_option" == 5 ]; then
            teacherPortal
        fi

    done
    teacherPortal
}

teacherPortal() {

    echo -e "\n[1]- Get short-form list"
    echo "[2]- Search by short name"
    echo "[3]- Back"
    read option
    if [ "$option" == 1 ]; then
        genarateShortNameList
        readTextFile "shortList.txt"
        teacherPortal
    elif [ "$option" == 2 ]; then
        searchByShortName
    elif [ "$option" == 3 ]; then
        main_menu
    fi

}

#---------------------------------------
#End of teachers section
#----------------------------------------

deleteCachedFile() {
    #remove everything belonsg if cached file exists
    checkProfileHtml="./profile.html"
    if test -f "$checkProfileHtml"; then
        rm ./profile.html
    fi

    checkResultHtml="./result.html"
    if test -f "$checkResultHtml"; then
        rm ./result.html
    fi

    checkBilltHtml="./bill.html"
    if test -f "$checkBilltHtml"; then
        rm ./bill.html
    fi

    checkProfile_info="./profile.txt"
    if test -f "$checkProfile_info"; then
        rm ./profile.txt
    fi
}

showLoggedInWarning() {
    echo -e "\n"
    echo $blink$RED$white"You dont set your student id,password yet!" $normal
    echo -e "\n"
}

checkBillingStatus() {
    RETURN_URL="unset"
    if [ -z "${STUDENT_ID}" ] && [ -z "${PASSWORD}" ]; then
        RETURN_URL="bill"
        showLoggedInWarning

        echo -e "\n"
        read -p"Want to login? [y/n]" ans
        if [ "$ans" == "Y" ] || [ "$ans" == "y" ]; then
            studentPortalLogin
        fi
    else

        checkBillFileExists=./bill.html

        if test -f "$checkBillFileExists"; then
            echo -e "\n..................................................\n"
            total_outstanding=$(htmlq -p "#cleContent .uwp-h2 font" --text <bill.html)
            echo $RED$white "$total_outstanding" $normal
            payable_paid=$(htmlq -p "#cleContent  .uwp-noborder" -w --text <bill.html)
            echo $BLUE$white $payable_paid $normal
            echo -e "\n..................................................\n"
        else
            echo -e "\n................................................."
            echo "Extracting bill status..."
            curl -s -X POST -F "studentID=$STUDENT_ID" -F "password=$PASSWORD" http://portal.green.edu.bd:81/Billing.php >>bill.html

            echo -e "\n..................................................\n"
            total_outstanding=$(htmlq -p "#cleContent .uwp-h2 font" --text <bill.html)
            echo $red $bold $total_outstanding $normal
            payable_paid=$(htmlq -p "#cleContent  .uwp-noborder" -w --text <bill.html)
            echo $blue $payable_paid $normal
            echo -e "\n..................................................\n"
        fi
    fi
    studentPortal

}

checkResult() {
    RETURN_URL="unset"
    askForFullResult() {
        read -p "Want to get full result[y/n]" ans
        if [ $ans == "Y" ] || [ $ans == "y" ]; then
            htmlq -p "#rest #cleContent table" -w --text <result.html
        fi
    }

    if [ -z "${STUDENT_ID}" ] && [ -z "${PASSWORD}" ]; then
        RETURN_URL="result"
        showLoggedInWarning

        echo -e "\n"
        read -p"Want to login? [y/n]" ans
        if [ "$ans" == "Y" ] || [ "$ans" == "y" ]; then
            studentPortalLogin
        fi
    else

        checkResultExists=./result.html

        if test -f "$checkResultExists"; then
            echo -e "\n..................................................\n"
            htmlq -p ".uwp-student-info" -t <result.html
            echo -e "..................................................\n"
            htmlq -p "#rest  #cleContent .uwp-h2" -w -t <result.html
            echo -e "..................................................\n"
            askForFullResult
        else
            echo -e "\n................................................."
            echo "Extracting your result ..."
            curl -s -X POST -F "studentID=$STUDENT_ID" -F "password=$PASSWORD" http://portal.green.edu.bd:81/Status.php >>result.html

            echo -e "\n..................................................\n"
            htmlq -p ".uwp-student-info" -t <result.html
            echo -e "..................................................\n"
            htmlq -p "#rest  #cleContent .uwp-h2" -w -t <result.html
            echo -e "..................................................\n"
            askForFullResult
        fi
    fi
    studentPortal
}

profileInfoExtract() {
    RETURN_URL="unset"
    if [ -z "${STUDENT_ID}" ] && [ -z "${PASSWORD}" ]; then
        RETURN_URL="profile"
        showLoggedInWarning

        echo -e "\n"
        read -p"Want to login? [y/n]" ans
        if [ "$ans" == "Y" ] || [ "$ans" == "y" ]; then
            studentPortalLogin
        fi
    else

        checkProfileExists=./profile.html

        if test -f "$checkProfileExists"; then
            echo -e "\n..................................................\n"
            htmlq -p "#cleContent tr" -w -t <profile.html
            echo -e "..................................................\n"
        else
            echo -e "\n................................................."
            echo "Extracting profile information..."
            curl -s -X POST -F "studentID=$STUDENT_ID" -F "password=$PASSWORD" http://portal.green.edu.bd:81/profile.php >>bill.html

            echo -e "\n..................................................\n"
            htmlq -p "#cleContent tr" -w -t <profile.html
            echo -e "..................................................\n"
        fi
    fi
    studentPortal

}
studentPortalLogin() {

    deleteCachedFile

    read -p "Enter your student id: " STUDENT_ID
    read -s -p "Enter your password(it will be shaded, dont worry!): " PASSWORD
    echo -e "\n.............................."
    #extracting student name
    curl -s -X POST -F "studentID=$STUDENT_ID" -F "password=$PASSWORD" http://portal.green.edu.bd:81/profile.php >>profile.html
    htmlq -p "#cleContent tr" -w -t <profile.html >>profile.txt
    STUDENT_NAME=$(sed -n 3p profile.txt)
    #extracting student name ends here

    echo "ID and Password is set!"
    echo ".............................."

    IS_LOGGED_IN="true"

    #redirecting to return url where the user comes from
    if [ "${RETURN_URL}" != "unset" ]; then
        if [ $RETURN_URL == "bill" ]; then
            checkBillingStatus
        elif [ $RETURN_URL == "result" ]; then
            checkResult
        elif [ $RETURN_URL == "profile" ]; then
            profileInfoExtract
        fi
    fi
    studentPortal
}

studentPortalLogout() {
    IS_LOGGED_IN="false"
    STUDENT_NAME=""
    STUDENT_ID=""
    PASSWORD=""

    echo -e 'Working on logout..wait a seconds....\n'

    #remove everything belonsg to logged id
    checkProfileHtml="./profile.html"
    if test -f "$checkProfileHtml"; then
        echo $red"Deleting Profile..."
        rm ./profile.html
    else
        echo "Deleting Profile..."
    fi

    checkResultHtml="./result.html"
    if test -f "$checkResultHtml"; then
        echo "Deleting result.html..."
        rm ./result.html
    else
        echo $red"Deleting result.html..."
    fi

    checkBilltHtml="./bill.html"
    if test -f "$checkBilltHtml"; then
        echo "Deleting bill.html..."
        rm ./bill.html
    else
        echo "Deleting bill.html..."
    fi

    checkProfile_info="./profile.txt"
    if test -f "$checkProfile_info"; then
        echo "Deleting profile.txt..."
        rm ./profile.txt
    else
        echo "Deleting profile.txt..."$normal
    fi

    echo -e "\n"
    echo "$green""$bold"'Logout complete!'"$normal"

    studentPortal
}

checkLoggedIn() {
    if [ -z "${STUDENT_ID}" ] && [ -z "${PASSWORD}" ]; then
        showLoggedInWarning
        studentPortalLogin
    fi
}

studentPortal() {
    echo -e "\n"
    echo "[1]-Billing Status"
    echo "[2]-Result"
    echo "[3]-Profile"
    if [ -z "${STUDENT_ID}" ] && [ -z "${PASSWORD}" ]; then
        echo "[4]-Login"
    else
        echo "[4]-Welcome, $bold $green $STUDENT_NAME!$normal Want to Logout?"
    fi

    echo "[5]-Back"
    read option

    if [ "$option" == 1 ]; then
        checkBillingStatus
    elif [ "$option" == 2 ]; then
        checkResult
    elif [ "$option" == 3 ]; then
        profileInfoExtract
    elif [ "$option" == 4 ]; then
        if [ "$IS_LOGGED_IN" = "true" ]; then
            studentPortalLogout
        else
            studentPortalLogin
        fi
    elif [ "$option" == 5 ]; then
        main_menu
    fi
}
#-------------------------------------------------
#main program start here
#-------------------------------------------------
if [ ! -d "assets" ]; then
    mkdir assets
    mkdir -p assets/teachers
fi

main_menu() {
    echo -e "\n[1]-Teacher Information"
    echo "[2]-Student Portal"
    echo "[3]-Exit"
    if [ "$(which htmlq)" == "" ]; then
        echo $blink$RED$white"[4]-Install Dependencies First" $normal
    fi
    read main_menu

    if [ "$main_menu" == 1 ]; then
        teacherPortal
    elif [ "$main_menu" == 2 ]; then
        studentPortal
    elif [ "$main_menu" == 3 ]; then
        echo "Happy scraping! Thank You for using me <3 "
        exit
    elif [ "$main_menu" == 4 ]; then
        installDependencies
    fi
}

main_menu
#-------------------------------------------------
#main program ends here
#-------------------------------------------------

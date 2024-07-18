<?php

// Define color constants
define('BLUE', "\033[0;34m");
define('RED', "\033[0;31m");
define('GREEN', "\033[0;32m");
define('YELLOW', "\033[0;33m");
define('NC', "\033[0m");

// Display welcome message
function display_welcome() {
    echo "\n";
    echo BLUE . "[+] =============================================== [+]" . NC . "\n";
    echo BLUE . "[+]                                                 [+]" . NC . "\n";
    echo BLUE . "[+]                AUTO INSTALLER THEMA             [+]" . NC . "\n";
    echo BLUE . "[+]                  © FOXSTORE OFFC                [+]" . NC . "\n";
    echo BLUE . "[+]                                                 [+]" . NC . "\n";
    echo BLUE . "[+] =============================================== [+]" . NC . "\n";
    echo "\n";
    echo "script ini di buat untuk mempermudah penginstalasian thema pterodactyle,\n";
    echo "dilarang keras untuk memperjual belikan.\n";
    echo "\n";
    echo "𝗪𝗛𝗔𝗧𝗦𝗔𝗣𝗣 :\n";
    echo "0853-7227-7748\n";
    echo "𝗬𝗢𝗨𝗧𝗨𝗕𝗘 :\n";
    echo "@foxstore_id\n";
    echo "𝗖𝗥𝗘𝗗𝗜𝗧𝗦 :\n";
    echo "@Chiwa\n";
    sleep(4);
    system('clear');
}

// Update and install jq
function install_jq() {
    echo "\n";
    echo BLUE . "[+] =============================================== [+]" . NC . "\n";
    echo BLUE . "[+]             UPDATE & INSTALL JQ                 [+]" . NC . "\n";
    echo BLUE . "[+] =============================================== [+]" . NC . "\n";
    echo "\n";
    system('sudo apt update && sudo apt install -y jq');
    if (system('which jq')) {
        echo "\n";
        echo GREEN . "[+] =============================================== [+]" . NC . "\n";
        echo GREEN . "[+]              INSTALL JQ BERHASIL                [+]" . NC . "\n";
        echo GREEN . "[+] =============================================== [+]" . NC . "\n";
    } else {
        echo "\n";
        echo RED . "[+] =============================================== [+]" . NC . "\n";
        echo RED . "[+]              INSTALL JQ GAGAL                   [+]" . NC . "\n";
        echo RED . "[+] =============================================== [+]" . NC . "\n";
        exit(1);
    }
    echo "\n";
    sleep(1);
    system('clear');
}

function check_token() {
    echo "\n";
    echo BLUE . "[+] =============================================== [+]" . NC . "\n";
    echo BLUE . "[+]               LICENSY FOXSTORE OFFC             [+]" . NC . "\n";
    echo BLUE . "[+] =============================================== [+]" . NC . "\n";
    echo "\n";

    $token_file = 'token.json';
    $correct_token = 'akkun';

    if (file_exists($token_file)) {
        $token_data = json_decode(file_get_contents($token_file), true);
        if (!$token_data || !isset($token_data['token'])) {
            echo RED . "Error: Invalid token.json file format.\n" . NC;
            exit(1);
        }

        $stored_token = $token_data['token'];

        if ($stored_token === $correct_token) {
            echo GREEN . "AKSES BERHASIL\n" . NC;
        } else {
            echo RED . "AKSES GAGAL\n" . NC;
            input_and_save_token($correct_token, $token_file);
        }
    } else {
        input_and_save_token($correct_token, $token_file);
    }
    system('clear');
}

function input_and_save_token($correct_token, $token_file) {
    while (true) {
        echo YELLOW . "MASUKAN AKSES TOKEN :" . NC . "\n";
        $user_token = trim(fgets(STDIN));

        if ($user_token === $correct_token) {
            $token_data = json_encode(['token' => $user_token], JSON_PRETTY_PRINT);
            file_put_contents($token_file, $token_data);
            echo GREEN . "AKSES BERHASIL\n" . NC;
            break;
        } else {
            echo RED . "AKSES GAGAL, SILAHKAN COBA LAGI.\n" . NC;
        }
    }
}

// Install theme
function install_theme() {
    while (true) {
        echo "\n";
        echo BLUE . "[+] =============================================== [+]" . NC . "\n";
        echo BLUE . "[+]                   SELECT THEME                  [+]" . NC . "\n";
        echo BLUE . "[+] =============================================== [+]" . NC . "\n";
        echo "\n";
        echo "PILIH THEME YANG INGIN DI INSTALL\n";
        echo "1. stellar\n";
        echo "2. billing\n";
        echo "3. enigma\n";
        echo "x. kembali\n";
        echo "masukan pilihan (1/2/3/x):\n";
        $SELECT_THEME = trim(fgets(STDIN));
        switch ($SELECT_THEME) {
            case '1':
                $THEME_URL = "https://github.com/DITZZ112/foxxhostt/raw/main/C2.zip";
                break 2;
            case '2':
                $THEME_URL = "https://github.com/DITZZ112/foxxhostt/raw/main/C1.zip";
                break 2;
            case '3':
                $THEME_URL = "https://github.com/DITZZ112/foxxhostt/raw/main/C3.zip";
                break 2;
            case 'x':
                return;
            default:
                echo RED . "Pilihan tidak valid, silahkan coba lagi." . NC . "\n";
        }
    }

    if (file_exists('/root/pterodactyl')) {
        system('sudo rm -rf /root/pterodactyl');
    }

    system("wget -q $THEME_URL");
    system('sudo unzip -o ' . basename($THEME_URL));

    if ($SELECT_THEME == '1') {
        install_stellar_theme();
    } elseif ($SELECT_THEME == '2') {
        install_billing_theme();
    } elseif ($SELECT_THEME == '3') {
        install_enigma_theme();
    }
}

function install_stellar_theme() {
    echo "\n";
    echo BLUE . "[+] =============================================== [+]" . NC . "\n";
    echo BLUE . "[+]                  INSTALLASI THEMA               [+]" . NC . "\n";
    echo BLUE . "[+] =============================================== [+]" . NC . "\n";
    echo "\n";
    system('sudo cp -rfT /root/pterodactyl /var/www/pterodactyl');
    system('curl -sL https://deb.nodesource.com/setup_16.x | sudo -E bash -');
    system('sudo apt install -y nodejs');
    system('sudo npm i -g yarn');
    system('cd /var/www/pterodactyl && yarn add react-feather');
    system('cd /var/www/pterodactyl && php artisan migrate');
    system('cd /var/www/pterodactyl && yarn build:production');
    system('cd /var/www/pterodactyl && php artisan view:clear');
    system('sudo rm /root/C2.zip');
    system('sudo rm -rf /root/pterodactyl');

    echo "\n";
    echo GREEN . "[+] =============================================== [+]" . NC . "\n";
    echo GREEN . "[+]                   INSTALL SUCCESS               [+]" . NC . "\n";
    echo GREEN . "[+] =============================================== [+]" . NC . "\n";
    echo "\n";
    sleep(2);
    system('clear');
}

function install_billing_theme() {
    echo "\n";
    echo BLUE . "[+] =============================================== [+]" . NC . "\n";
    echo BLUE . "[+]                  INSTALLASI THEMA               [+]" . NC . "\n";
    echo BLUE . "[+] =============================================== [+]" . NC . "\n";
    echo "\n";
    system('sudo cp -rfT /root/pterodactyl /var/www/pterodactyl');
    system('curl -sL https://deb.nodesource.com/setup_16.x | sudo -E bash -');
    system('sudo apt install -y nodejs');
    system('npm i -g yarn');
    system('cd /var/www/pterodactyl && yarn add react-feather');
    system('cd /var/www/pterodactyl && php artisan billing:install stable');
    system('cd /var/www/pterodactyl && php artisan migrate');
    system('cd /var/www/pterodactyl && yarn build:production');
    system('cd /var/www/pterodactyl && php artisan view:clear');
    system('sudo rm /root/C1.zip');
    system('sudo rm -rf /root/pterodactyl');

    echo "\n";
    echo GREEN . "[+] =============================================== [+]" . NC . "\n";
    echo GREEN . "[+]                  INSTALL SUCCESS                [+]" . NC . "\n";
    echo GREEN . "[+] =============================================== [+]" . NC . "\n";
    echo "\n";
    sleep(2);
    system('clear');
}

function install_enigma_theme() {
    echo "\n";
    echo BLUE . "[+] =============================================== [+]" . NC . "\n";
    echo BLUE . "[+]                  INSTALLASI THEMA               [+]" . NC . "\n";
    echo BLUE . "[+] =============================================== [+]" . NC . "\n";
    echo "\n";

    // Prompt user for input
    echo YELLOW . "Masukkan link wa (https://wa.me...) : " . NC;
    $LINK_WA = trim(fgets(STDIN));
    echo YELLOW . "Masukkan link group (https://.....) : " . NC;
    $LINK_GROUP = trim(fgets(STDIN));
    echo YELLOW . "Masukkan link channel (https://...) : " . NC;
    $LINK_CHNL = trim(fgets(STDIN));

    // Replace placeholders with user input
    system("sudo sed -i 's|LINK_WA|$LINK_WA|g' /root/pterodactyl/resources/scripts/components/dashboard/DashboardContainer.tsx");
    system("sudo sed -i 's|LINK_GROUP|$LINK_GROUP|g' /root/pterodactyl/resources/scripts/components/dashboard/DashboardContainer.tsx");
    system("sudo sed -i 's|LINK_CHNL|$LINK_CHNL|g' /root/pterodactyl/resources/scripts/components/dashboard/DashboardContainer.tsx");

    // Continue with the installation
    system('sudo cp -rfT /root/pterodactyl /var/www/pterodactyl');
    system('curl -sL https://deb.nodesource.com/setup_16.x | sudo -E bash -');
    system('sudo apt install -y nodejs');
    system('sudo npm i -g yarn');
    system('cd /var/www/pterodactyl && yarn add react-feather');
    system('cd /var/www/pterodactyl && php artisan migrate');
    system('cd /var/www/pterodactyl && yarn build:production');
    system('cd /var/www/pterodactyl && php artisan view:clear');
    system('sudo rm /root/C3.zip');
    system('sudo rm -rf /root/pterodactyl');

    echo "\n";
    echo GREEN . "[+] =============================================== [+]" . NC . "\n";
    echo GREEN . "[+]                   INSTALL SUCCESS               [+]" . NC . "\n";
    echo GREEN . "[+] =============================================== [+]" . NC . "\n";
    echo "\n";
    sleep(5);
    system('clear');
}

// Uninstall theme
function uninstall_theme() {
    echo "\n";
    echo BLUE . "[+] =============================================== [+]" . NC . "\n";
    echo BLUE . "[+]                    DELETE THEME                 [+]" . NC . "\n";
    echo BLUE . "[+] =============================================== [+]" . NC . "\n";
    echo "\n";
    system('bash <(curl https://raw.githubusercontent.com/Foxstoree/pterodactyl-auto-installer/main/repair.sh)');
    echo "\n";
    echo GREEN . "[+] =============================================== [+]" . NC . "\n";
    echo GREEN . "[+]                 DELETE THEME SUKSES             [+]" . NC . "\n";
    echo GREEN . "[+] =============================================== [+]" . NC . "\n";
    echo "\n";
    sleep(2);
    system('clear');
}

// Main script
display_welcome();
install_jq();
check_token();

while (true) {
    system('clear');
    echo "\n";
    echo BLUE . "[+] =============================================== [+]" . NC . "\n";
    echo BLUE . "[+]                   SELECT OPTION                 [+]" . NC . "\n";
    echo BLUE . "[+] =============================================== [+]" . NC . "\n";
    echo "\n";
    echo "SELECT OPTION :\n";
    echo "1. Install theme\n";
    echo "2. Uninstall theme\n";
    echo "x. Exit\n";
    echo "Masukkan pilihan (1/2/x):\n";
    $MENU_CHOICE = trim(fgets(STDIN));
    system('clear');

    switch ($MENU_CHOICE) {
        case '1':
            install_theme();
            break;
        case '2':
            uninstall_theme();
            break;
        case 'x':
            echo "Keluar dari skrip.\n";
            exit(0);
        default:
            echo RED . "Pilihan tidak valid, silahkan coba lagi.\n" . NC;
    }
}
?>

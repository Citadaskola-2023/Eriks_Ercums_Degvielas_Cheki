# **Fuel receipt storage**

### **Description**
Simple web application to save and view fuel receipts.
[Licence](https://github.com/Citadaskola-2023/Eriks_Ercums_Degvielas_Cheki/blob/main/LICENSE)
### **Requirements**
1. [Git](https://git-scm.com/downloads)
2. [Docker](https://www.docker.com/get-started/)

### **Set up**
1. Clone the repository
   `git clone git@github.com:Citadaskola-2023/Eriks_Ercums_Degvielas_Cheki.git`
2. Install dependencies
`docker run --rm --interactive --tty \
   --volume /$PWD:/app \
   composer install`
3. Start
`docker compose up -d`


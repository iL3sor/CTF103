FROM node:16

ENV NODE_ENV=production

WORKDIR /app

COPY ["package.json", "package-lock.json*", "./"]

RUN npm install --production
RUN apt-get update && apt-get install -y gconf-service libasound2 libatk1.0-0 libcairo2 libcups2 libfontconfig1 libgdk-pixbuf2.0-0 libgtk-3-0 libnspr4 libpango-1.0-0 libxss1 fonts-liberation libappindicator1 libnss3 lsb-release xdg-utils

RUN wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
RUN dpkg -i google-chrome-stable_current_amd64.deb; apt-get -fy install
COPY . .

RUN apt-get install ufw -y
RUN ufw default deny incoming
RUN ufw default deny outgoing
RUN ufw allow from 172.21.0.4 port 80
RUN ufw allow to 172.21.0.4 port 80
RUN ufw allow dns

CMD [ "node", "bot.js" ]
const puppeteer = require('puppeteer');
async function test(){
    const browser = await puppeteer.launch({headless:true,slowMo:90, args: [
        "--no-sandbox",
        "--disable-gpu",
        ]});
    const page = await browser.newPage();
    await page.goto('http://172.21.0.4/?page=login');
    await page.type("input[name=username]", 'admin');
    await page.type("input[name=password]", 'a');
    await page.click("button[name=login]");
    await browser.close();
};
setInterval(test,30000);
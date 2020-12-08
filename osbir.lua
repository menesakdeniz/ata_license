local f = io.popen('wmic bios get serialnumber')
local t = tostring(f:read('*a'))
local serial = t:gsub('%s+', '')
local ipwithspaces = 'https://project63.net/license/check/serial.php?id=' .. t
local ip = ipwithspaces:gsub('%s+', '')
local ipaddress = nil
local DISCORD_WEBHOOK = 'asd'
local DISCORD_NAME = 'Izinsiz Kullanım Bot'
local DISCORD_IMAGE = 'https://cdn.discordapp.com/attachments/742081322326949948/744646207002902589/Danger-Sign-PNG-Pic.png'
local DISCROD_ONAY = 'https://cdn.discordapp.com/attachments/745612321711325185/746081145783058482/New_Project_3.jpg'
local DISCROD_CANCEL = 'https://cdn.discordapp.com/attachments/745612321711325185/746075647595642960/New_Project_2.jpg'

-- COPYRIGHT BY KEL MUSTAFA DC: Kel Mustafa#3131

PerformHttpRequest('http://bot.whatismyipaddress.com/', function (errorCode, resultDataa, resultHeaders)
    ipaddress = resultDataa
end)

-- COPYRIGHT BY KEL MUSTAFA DC: Kel Mustafa#3131

PerformHttpRequest(ip, function (errorCode, resultData, resultHeaders)	
    Citizen.Wait(400)
    if errorCode ~= 200 then
        WebHookSend(15466505,'**Izinsiz Kullanım Tespit Edildi asd**','Izinsiz bir kullanım tespit edildi ve paketin çalışması engellendi',DISCROD_CANCEL,DISCORD_WEBHOOK)
        Citizen.Wait(500)
        os.exit()
    end
	if resultData ~= 'True' then			
        WebHookSend(15466505,'**Izinsiz Kullanım Tespit Edildi asd**','Izinsiz bir kullanım tespit edildi ve paketin çalışması engellendi',DISCROD_CANCEL,DISCORD_WEBHOOK)
        Citizen.Wait(500)
        os.exit()
    else
        WebHookSend(5111572,'**DOĞRULAMA BAŞARILI**','Paket doğrulandı ve çalıştırıldı',DISCROD_ONAY,DISCORD_WEBHOOK)
	end		
end)

-- COPYRIGHT BY KEL MUSTAFA DC: Kel Mustafa#3131

Citizen.CreateThread(function()
    while true do
        Citizen.Wait(60000)
        print("Copyright by KEL MUSTAFA DC: Kel Mustafa#3131")
        PerformHttpRequest(ip, function (errorCode, resultData, resultHeaders)
            if resultData ~= 'True' or errorCode ~= 200 then		
                WebHookSend(15466505,'**Izinsiz Kullanım Tespit Edildi - asd**','Izinsiz bir kullanım tespit edildi ve paketin çalışması engellendi',DISCROD_CANCEL,DISCORD_WEBHOOK)
                Citizen.Wait(500)
                os.exit()
            end
        end)
    end
end)

-- COPYRIGHT BY KEL MUSTAFA DC: Kel Mustafa#3131

function WebHookSend(color,title,desc,image,whook)	
	local connect = {
        {
            ['color'] = color,
            ['title'] = title,
            ['description'] = desc,
            ['footer'] = {
                ['text'] = 'İzinsiz Kullanım Engelleme Sistemi',
                ['icon_url'] = 'https://cdn.discordapp.com/attachments/742081322326949948/744646207002902589/Danger-Sign-PNG-Pic.png',
            },
            ['image'] = {
                ['url'] = image,
            },
            ['fields'] = {{
                ['name'] = '**SERI NUMARASI**',
                ['value'] = '*' .. serial .. '*' ,
            },
            {
                ['name'] = '**IP ADRESI**',
                ['value'] = '*' ..  ipaddress .. '*',
            }},
        }
    }
    PerformHttpRequest(whook, function(err, text, headers) end, 'POST', json.encode({username = DISCORD_NAME, embeds = connect, avatar_url = DISCORD_IMAGE}), { ['Content-Type'] = 'application/json' })
end

-- COPYRIGHT BY KEL MUSTAFA DC: Kel Mustafa#3131

---
layout: podcast
excerpt_separator: '<!--excerpt-above-->'
title: 'Snake Oilers #2: Part 2: Authentication tech from Yubico and Remediant'
tagline: 'A great podcast for people interested in locking down Windows accounts...'
author: patrick-gray
explicit: 'No'
permalink: snakeoilers2pt2
sponsor: '-- none --'
categories:
    - risky-business
media_url: 'http://media2.risky.biz/snakeoil2pt2a.mp3'
media_length: '29800054'
media_type: audio/mpeg
show_notes:
    -  title: 'Yubico -- U2F two factor auth hardware, natively supported by Windows'
       link: 'https://yubico.com'
       description: '' 
    -  title: 'Remediant -- an alternative to password vaults'
       link: 'https://www.remediant.com/'
       description: '' 

---
This podcast deals with authentication tech -- in particular, if you manage a Windows network, you'll want to listen to this to get an idea of some different approaches to solving some of your authentication challenges.

This isn't our weekly show, this is something we do four times a year -- we get a bunch of vendors together and they explain their tech. Last week I published interviews with Crowdstrike, Replicated and AttackIQ, go <a href='https://risky.biz/snakeoilers2'>check them out</a> if you haven't already, but I wanted to break out these two companies into their own podcast.

In this edition we're going to hear from two companies -- Remediant and Yubico.

Yubico, of course, makes yubikeys, the hardware authentication device used by companies like Google and Facebook to lock down accounts. I own one, and it wasn't a freebie, I paid for it. A lot of security people use these USB devices because they work really, really well. 

What I didn't know, because I'm a dumbass, is there's native support for Yubikeys in Windows. So if you want to add hardware-backed two factor authentication to your Windows accounts, this is one way to do it.

But before we talk to Yubico, we're going to hear from Remediant. 

Remediant is a start up that also makes some interesting Windows auth tech. Now, a lot of Risky Business listeners operate in high security or compliance heavy environments. This will often mean using password vault technology for better privileged account management. Remediant has something they think is better.

Basically they have created a tech that lets you enable and disable privileged accounts on, like a time-lock basis. If you have to do some admin work on a box, you log in to your Remediant server, enable that account for a set period of time, then off you go. Easy. It's a very light touch way of solving some pretty serious management headaches, and it's very easy to audit, which will keep our friends in heavily regulated environments very happy. 
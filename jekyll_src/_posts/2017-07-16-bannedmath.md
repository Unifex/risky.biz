---
layout: blog
excerpt_separator: '<!--excerpt-above-->'
title: 'No encryption was harmed in the making of this intercept'
tagline: 'This is a data access war, not a crypto war...'
author: patrick-gray
explicit: 'No'
permalink: bannedmath
sponsor: '-- none --'
categories: null
media_url: ''
media_length: ''
media_type: ''

---
(UPDATE 17/7/17: The original version of this post implied major technology companies were only handing over user metadata via Mutual Legal Assistance Treaties. That is not the case and the piece has been edited for clarity.)

Over the last few days people have been losing their minds over an announcement by the Australian government that it will soon introduce laws to compel technology companies to hand over the communications of their users.

This has largely been portrayed as some sort of anti-encryption push, but that's not my take. At all.

Before we look at the government's proposed "solution," it might make sense to define some problems, as far as law enforcement and intelligence agencies are concerned. The first problem has very little to do with end-to-end encryption and a lot more to do with access to messaging metadata.

If you're Australian and you're reading this blog, you'd most likely know that Australia passed a metadata retention law that came into effect in April this year. It requires telecommunications companies and ISPs (i.e. carriage service providers, or CSPs) to keep a record of things like the IPs assigned to internet users (useful for matching against seized logs) as well as details around phone, SMS and email use.

The problem is, people have moved towards offshore-based services that are not required, under Australian law, to keep or hand over such metadata. Think of iMessage, WhatsApp, Signal, Wickr and Telegram.

Australian authorities do have options when it comes to requesting metadata from these companies. They can just ask, and depending on the company they might get something back. I'm told the major companies generally help out, especially those with a presence here. Companies like Berlin-based Telegram? Not so much.

Some other companies might just tell you to go away. Then the only way forward, depending on where the app maker is based, might be an MLAT -- a request through a Mutual Legal Assistance Treaty, specifically, the Mutual Assistance in Criminal Matters Act of 1987. 

Detective plod draws up the paperwork, then the request goes off to our Attorney General's Department, then to the US AG, then to the FBI, and then you might get something back about a year later. If you're lucky. 

If you're seeking useful metadata involving communications that took place via Signal, you won't get anything back anyway because they just don't log much. (This is also an issue for US law enforcement.)

Currently, metadata access is at the whim of a patchwork of company policies, and the metadata tap -- in the case of some communications apps -- has been turned off completely. And as far as law enforcement is concerned, blocks to obtaining metadata are a very big problem.

There are no easy solutions here, but it's part of the reason you've heard our Attorney General George Brandis talk a lot about treaties and mutual assistance over the last few months. Currently, there's nothing the Australian government can do to speed up the process when authorities are dealing with offshore organisations.

The second problem involves messaging content. Now that we live in a world where anyone can buy a secure mobile handset (an iPhone) and use an end-to-end (e2e) encrypted messaging application (WhatsApp, Signal etc), there are serious challenges around intercepting communications. Currently, if you ask Facebook for some WhatsApp messaging data, they can simply say they don't have it. That's the beauty of end-to-end encryption.

But the Australian government has announced proposed laws that will seek to compel tech companies to hand over the content of user communications, e2e encrypted or not.

It's very, very important to note at this point that there are legal barriers to obtaining communications content that simply don't apply to metadata. Metadata is made available by request in most jurisdictions (i.e. without a warrant), but content is a whole other ballgame. In the case of a typical criminal investigation the police need a telecommunications intercept warrant to tap someone's phone or internet connection. They can't simply request it.

It's here that people have spun off planet earth into frankly bizarre speculation as to what the government wants.

I've seen an awful lot of people suggesting that the government will compel tech companies to downgrade the encryption they use in their products, either by forcing them to adopt weak ciphers or maybe some sort of funny curve, reminiscent of the suspect Dual Elliptic Curve Deterministic Random Bit Generator incorporated into RSA's BSAFE library. (That's a mouthful, but you can read about that <a href='https://en.wikipedia.org/wiki/Dual_EC_DRBG ' target='new'>here</a>.)

The thinking is, if everyone starts running crap crypto, the coppers can sniff the communications off the wire.

Let me put this bluntly: If this is what the government winds up suggesting, then by all means hand me a bullhorn and show me where to point it. It is a ridiculous idea that would erode so many of the security gains that we've made over the last decade.

But this is not what the government will suggest. If you want to know what this will look like from a technical perspective, just look at how authorities currently address this problem.

Thanks to our pal Phineas Fisher, we've had a glimpse into the sausage factory that is the law enforcement trojanware industry. Gamma Group and Hacking Team, two companies that make surveillance software for mobile phones, were both hacked by Mr. Fisher and the gory details of their operations laid bare.

What we learned is that law enforcement organisations already have perfectly functional trojans that they can install on a target's phone. These trojans <a href='https://thenextweb.com/insider/2015/08/06/hacking-team-reverse-engineered-whatsapp-facebook-and-others-to-steal-your-iphones-data/#.tnw_QdJAKMJX'>can already intercept communications from encrypted apps</a>.

If you can access the endpoint -- the phone -- then you can access the user's messages. No weakening of encryption is required.

These types of law enforcement trojans have typically been delivered to handsets by exploiting security vulnerabilities in mobile operating systems. Unfortunately for law enforcement, but fortunately for us, exploiting vulnerabilities on mobile handsets has become more and more difficult, time consuming and expensive. iOS is the leader here, a damn fine operating system, but Android is definitely catching up.

I want to spell this out clearly so there's no confusion: The government already has the legal authority to access your end-to-end encrypted messages if they have a warrant. The barrier is not a legal one, it's a technical one. Access to the expensive exploits used to deliver interception software to handsets is being rationed due to cost, feeds an industry full of shady players like Hacking Team, and in some cases agencies are simply unable to install surveillance software on to the phones of some really god-awful people, even though they have a warrant.

So, the government wants the tech companies to "fix" this for them. That's why they're not talking technical details. The regime will not be prescriptive, and thankfully the government knows that it's probably not the most appropriate organisation to advise Apple or Google on the finer points of technology.

The feeling is non-US law enforcement and intelligence agencies aren't getting the coverage they'd need to do their jobs. This is why we've seen New Zealand and the UK pass laws that supposedly compel US companies to assist them when they ask. (I hear they're not being enforced yet.)

So let's break down how it may work: Under this law, the AFP might ask Facebook, which owns WhatsApp, to hand over the message history and future messages of user X, because they have a court-issued warrant.

Now it's all very well and good for WhatsApp to argue that it doesn't have the technical means to do so, which is a response that has lead to all sorts of tangles in Brazil's courts, but the Australian law will simply say "we don't care. Get them.".

In practice, there are a number of ways to skin this cat that don't involve weakening encryption. 

For example, Until May this year, WhatsApp backups <a href='http://www.telegraph.co.uk/technology/2017/05/09/whatsapp-has-encrypted-iphone-backups-matters/' target='new'>weren't even encrypted</a>. (That's right, all this song and dance about your messages being end-to-end encrypted, only to have them shunted into services like Apple's iCloud, and we all know how well protected iCloud is!)

Even now, the precise encryption technique used by WhatsApp isn't clear. Are they using a key generated on your device to encrypt your messages? That would be of limited use, considering the point of a backup is to restore your message history when you lose your phone and the corresponding encryption key. So my guess is it's a form of encryption that is recoverable by WhatsApp.

What if the user doesn't have backups turned on? Well, I'm sure there are some clever people out there at WhatsApp HQ who could figure out how to turn on a user's backups for them.

A retort I often hear when I lay out a scenario like that one is that users will just move to another app, maybe something like Telegram, which is based in Germany. At that point, an enterprising police officer might contact either Google or Apple, two companies that control something like 99% of the cellphone market share, and ask them to devise a way to retrieve the requested data from that device. Like, say, pushing a signed update to the target handset that will be tied to that device's UDID (Unique Device Identifier). That way there's no chance the coppers can intercept that update and re-use it on whomever they want.

Again, no encryption was harmed in the making of this intercept.

There are some legitimate concerns around how a regime like this could be abused. However, the legal bar for content interception here in Australia is much higher than for metadata. Content access requires a warrant. If cops were looking to abuse this access then they'd need to engage in some pretty serious criminality, like forging warrants. And if the access regime revolves around asking the tech companies to do the grunt-work on behalf of the authorities, all intercepts should actually be easy to audit periodically.

In other words it would be a stupid way to spy on your girlfriend.

Now look, I'm not advocating for these laws. I'm not. What I am trying to do is move the goalposts for this discussion. The responses that I've seen to this proposal from the Twitterati have mostly been really daffy. People will insist the government doesn't know what the hell it's asking for (it does), that it wants to break maths (it doesn't) and that it's impossible for technology companies to provide law enforcement with what they need without introducing unacceptable new vulnerabilities and risks into our technology ecosystem (depends on your definition of "unacceptable".).

I'd like to see the goalposts set up around a much simpler discussion than one about technology and encryption: To what degree do we believe, as a society, that the right to privacy is absolute?

Do we believe that law enforcement bodies should have the authority to monitor the communications of people suspected of serious criminal offences? If so, what should the legal process for provisioning that access look like? I mentioned auditing access under this scheme a couple of paragraphs ago. If we're going to have a regime like this, can we have a decent access auditing scheme please? These are the sorts of things I would prefer to be talking about.

It's also important to remember that Australia is not America. We don't really have the same libertarian streak as our US cousins, so it's entirely possible there won't be a substantial backlash to these proposals. That makes framing this discussion properly -- as a conversation about balancing our need for privacy with our desire for safety -- vitally important.

If people who want to participate in this debate keep screaming that the government consists of a bunch of idiots who want to outlaw maths, well, the real conversation just won't happen and no meaningful controls around the extent of access and the oversight of that access will be granted.

Not that you can expect grown up conversations between the tech firms and the government. The tech companies will fight this tooth and nail, both on libertarian/political grounds, and on business grounds. The government will do the usual scaremongering around terrorists and pedophiles. Expect some downright misleading information from both sides and absolutely bonkers salvos fired in both directions. 

Can't wait.

PS: Blind Freddy <a href='https://www.wired.com/2013/08/stop-clumping-tech-companies-in-with-government-in-the-surveillance-scandals-they-may-be-at-war/'>could have seen this coming</a>.
import json
import re

def strip_tags(html):
    text = re.sub('<[^<]+?>', '', html)
    return text.strip()

with open('posts.json', 'r', encoding='utf-8') as f:
    posts = json.load(f)

print(f"Total posts: {len(posts)}")

ai_phrases = ["まとめますと", "結論として", "この記事では", "重要です", "AI", "解説します"]
first_person = ["私", "僕", "自分", "筆者", "Yuny", "yuny", "体験", "実務", "現場"]

for post in posts:
    title = post['title']['rendered']
    raw_content = post['content']['rendered']
    text = strip_tags(raw_content)
    
    char_count = len(text)
    
    # Check for first person / experience keywords
    fp_matches = [word for word in first_person if word in text]
    ai_matches = [word for word in ai_phrases if word in text]
    
    print(f"---")
    print(f"Title: {title}")
    print(f"Char Count: {char_count}")
    print(f"Experience/FP Words: {len(fp_matches)} ({', '.join(fp_matches)})")
    print(f"AI/Filler Words: {len(ai_matches)} ({', '.join(ai_matches)})")
    print(f"Snippet: {text[:100].replace(chr(10), ' ')}...")

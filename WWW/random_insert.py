import mysql.connector
from faker import Faker
import random

# 配置MySQL连接
config = {
    'user': 'root',
    'password': 'root',
    'host': 'localhost',
    'database': 'db_exp'
}

# 连接到MySQL数据库
conn = mysql.connector.connect(**config)
cursor = conn.cursor()

# 使用Faker库生成随机名称
fake = Faker()

# 定义要插入的记录数
num_records = 1000000

# SQL插入语句
insert_query = """
INSERT INTO employees (name, department_id) VALUES (%s, %s)
"""

# 生成并插入随机数据
for _ in range(num_records):
    name = fake.name()
    department_id = random.randint(0, 9)  # 假设有10个部门，ID为1到10
    cursor.execute(insert_query, (name, department_id))

# 提交事务
conn.commit()

# 关闭连接
cursor.close()
conn.close()

print(f"成功插入了{num_records}条记录到employees表中。")

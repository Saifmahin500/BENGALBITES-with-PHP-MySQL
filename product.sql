INSERT INTO products (product_name, description, product_image, unit_price, selling_price, stock_amount, category_id, created_at) 
VALUES
('Club Sandwich', 'Layered sandwich with chicken, bacon, lettuce, tomato, and mayo.', 'image_placeholder.jpg', 150, 180, 70, (SELECT id FROM categories WHERE category_name = 'Sandwich & Wraps' LIMIT 1), CURRENT_TIMESTAMP),
('Veggie Wrap', 'Soft tortilla wrap filled with fresh veggies and hummus.', 'image_placeholder.jpg', 120, 150, 80, (SELECT id FROM categories WHERE category_name = 'Sandwich & Wraps' LIMIT 1), CURRENT_TIMESTAMP),
('French Fries', 'Crispy golden fries served with ketchup.', 'image_placeholder.jpg', 60, 80, 100, (SELECT id FROM categories WHERE category_name = 'Fried & Snacks' LIMIT 1), CURRENT_TIMESTAMP),
('Chicken Nuggets', 'Crunchy chicken nuggets served with spicy dip.', 'image_placeholder.jpg', 100, 130, 90, (SELECT id FROM categories WHERE category_name = 'Fried & Snacks' LIMIT 1), CURRENT_TIMESTAMP),
('Spaghetti Bolognese', 'Classic Italian pasta with rich meat sauce and parmesan.', 'image_placeholder.jpg', 220, 260, 50, (SELECT id FROM categories WHERE category_name = 'Pasta & Noodles' LIMIT 1), CURRENT_TIMESTAMP),
('Chicken Chow Mein', 'Stir-fried noodles with chicken and mixed vegetables.', 'image_placeholder.jpg', 200, 240, 60, (SELECT id FROM categories WHERE category_name = 'Pasta & Noodles' LIMIT 1), CURRENT_TIMESTAMP),
('Burger Combo', 'Beef burger with fries and a soft drink.', 'image_placeholder.jpg', 250, 300, 40, (SELECT id FROM categories WHERE category_name = 'Combo Meals' LIMIT 1), CURRENT_TIMESTAMP),
('Pizza Combo', 'Personal pizza with garlic bread and soda.', 'image_placeholder.jpg', 400, 450, 30, (SELECT id FROM categories WHERE category_name = 'Combo Meals' LIMIT 1), CURRENT_TIMESTAMP),
('Cold Coffee', 'Chilled coffee with ice cream and whipped cream.', 'image_placeholder.jpg', 120, 150, 80, (SELECT id FROM categories WHERE category_name = 'Beverages' LIMIT 1), CURRENT_TIMESTAMP),
('Fresh Lemonade', 'Refreshing lemonade with mint leaves.', 'image_placeholder.jpg', 80, 100, 90, (SELECT id FROM categories WHERE category_name = 'Beverages' LIMIT 1), CURRENT_TIMESTAMP),
('Chocolate Brownie', 'Rich chocolate brownie topped with nuts.', 'image_placeholder.jpg', 100, 130, 50, (SELECT id FROM categories WHERE category_name = 'Desserts' LIMIT 1), CURRENT_TIMESTAMP),
('Vanilla Ice Cream', 'Creamy vanilla ice cream served in a cup or cone.', 'image_placeholder.jpg', 90, 120, 70, (SELECT id FROM categories WHERE category_name = 'Desserts' LIMIT 1), CURRENT_TIMESTAMP);

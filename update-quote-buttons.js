// Script to update all Request A Quote buttons
// This is a helper script - run manually or integrate into build process

const fs = require('fs');
const path = require('path');

const productPages = {
    'ligen-power-3500.html': 'LIGEN-INV3500 - 48VDC',
    'ligen-power-5000.html': 'Ligen Power®- 5000',
    'ligen-power-2000.html': 'LIGEN-INV2000 - 24VDC',
    'ligen-power-1500.html': 'Ligen Power®- 1500',
    'ligen-power-1000.html': 'Ligen Power®- 1000',
    'ligen-power-850.html': 'Ligen Power®- 850',
    'ligen-power-600s.html': 'Ligen Power®- 600S',
    'ligen-power-300.html': 'Ligen Power®- 300',
    'ligen-inv5000-96vdc.html': 'LIGEN-INV5000 – 96 VDC',
    'ligen-inv5000-48vdc.html': 'LIGEN-INV5000 - 48VDC',
    'ligen-inv2000-24vdc.html': 'LIGEN-INV2000 - 24VDC',
    'ligen-inv2000-pwm.html': 'Ligen Power® PWM PCU -2000VA',
    'ligen-rrv1500-pwm.html': 'Ligen Power® PWM PCU -1500VA',
    'ligen-inv1000-pwm.html': 'Ligen Power® PWM PCU -1000VA',
    'ligen-inv850-pwm.html': 'Ligen Power® PWM PCU -850VA',
    'ligen-inv600-pwm.html': 'Ligen Power® PWM PCU -600VA',
    'ligen-inv300-pwm.html': 'Ligen Power® PWM PCU -300VA',
    'solar-street-light.html': 'Solar Street Light'
};

function updateQuoteButton(filePath, productName) {
    const content = fs.readFileSync(filePath, 'utf8');
    
    // Pattern 1: href="contact.html" with Request A Quote
    const pattern1 = /<a\s+href=["']contact\.html["'][^>]*>Request\s+A\s+Quote/i;
    const replacement1 = `<a href="javascript:void(0);" onclick="openQuoteModal('${productName}', '${path.basename(filePath)}'); return false;" style="cursor: pointer;"`;
    
    // Pattern 2: href="#contact-form" with Request A Quote
    const pattern2 = /<a\s+href=["']#contact-form["'][^>]*>Request\s+A\s+Quote/i;
    const replacement2 = `<a href="javascript:void(0);" onclick="openQuoteModal('${productName}', '${path.basename(filePath)}'); return false;" style="cursor: pointer;"`;
    
    let updated = content;
    if (pattern1.test(updated)) {
        updated = updated.replace(pattern1, replacement1);
    }
    if (pattern2.test(updated)) {
        updated = updated.replace(pattern2, replacement2);
    }
    
    if (updated !== content) {
        fs.writeFileSync(filePath, updated, 'utf8');
        console.log(`Updated: ${filePath}`);
        return true;
    }
    return false;
}

// Update all product pages
Object.keys(productPages).forEach(file => {
    const filePath = path.join(__dirname, file);
    if (fs.existsSync(filePath)) {
        updateQuoteButton(filePath, productPages[file]);
    }
});

console.log('Done updating quote buttons!');


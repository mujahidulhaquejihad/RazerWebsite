let cabinet_selector = document.getElementById('cabinet_select');
let cpu_selector = document.getElementById('cpu_select');
let gpu_selector = document.getElementById('gpu_select');
let ram_selector = document.getElementById('ram_select');
let mb_selector = document.getElementById('mb_select');
let ssd_selector = document.getElementById('ssd_select');
let hdd_selector = document.getElementById('hdd_select');
let psu_selector = document.getElementById('psu_select');
let cpu_cooler_selector = document.getElementById('cpu_cooler_select');

let dropdowns = document.querySelectorAll('select');

function input_entered(name) {
  var selectId = '';
  if (name == 'cabinet') selectId = 'cpu_select';
  else if (name == 'cpu') selectId = 'gpu_select';
  else if (name == 'gpu') selectId = 'ram_select';
  else if (name == 'ram') selectId = 'mb_select';
  else if (name == 'mb') selectId = 'ssd_select';
  else if (name == 'ssd') selectId = 'hdd_select';
  else if (name == 'hdd') selectId = 'psu_select';
  else if (name == 'power_supply') selectId = 'cpu_cooler_select';
  if (selectId) {
    var wrap = document.getElementById(selectId).closest('.product-select-wrap');
    if (wrap) wrap.style.display = 'block';
  }
}

function syncSearch(selectEl) {
  var wrap = selectEl.closest('.product-select-wrap');
  if (!wrap) return;
  var searchInput = wrap.querySelector('.product-search');
  if (!searchInput) return;
  var idx = selectEl.selectedIndex;
  if (idx > 0 && selectEl.options[idx].value !== '0') {
    searchInput.value = selectEl.options[idx].text.trim();
  } else {
    searchInput.value = '';
  }
}

function filterSelectBySearch(searchText, selectId) {
  var select = document.getElementById(selectId);
  if (!select) return;
  var q = (searchText || '').toLowerCase().trim();
  for (var i = 0; i < select.options.length; i++) {
    var opt = select.options[i];
    if (opt.value === '0') { opt.disabled = false; continue; }
    opt.disabled = q === '' ? false : opt.text.toLowerCase().indexOf(q) === -1;
  }
}

document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.product-search').forEach(function(input) {
    input.addEventListener('input', function() {
      var selectId = this.getAttribute('data-for');
      filterSelectBySearch(this.value, selectId);
    });
    input.addEventListener('focus', function() {
      var selectId = this.getAttribute('data-for');
      var select = document.getElementById(selectId);
      if (select) select.size = Math.min(8, select.options.length);
    });
    input.addEventListener('blur', function() {
      var selectId = this.getAttribute('data-for');
      var select = document.getElementById(selectId);
      if (select) select.size = 1;
    });
  });
});

let total_cost;
function reset_selection() {
  document.getElementById('cabinet_select').selectedIndex = 0;
  var allSelects = document.querySelectorAll('.product-select-wrap select');
  for (var i = 1; i < allSelects.length; i++) {
    allSelects[i].selectedIndex = 0;
    allSelects[i].closest('.product-select-wrap').style.display = 'none';
  }
  document.querySelectorAll('.product-search').forEach(function(inp) {
    inp.value = '';
    var sid = inp.getAttribute('data-for');
    if (sid) filterSelectBySearch('', sid);
  });
  total_cost = 0;
  document.getElementById('total_label').innerText = 'Total: ' + total_cost;
  document.getElementById('cabinet_image').src = '';
}

function calc_total(value) {
  total_cost = 0;
  let selected_list = document.querySelectorAll('select');
  for (let i = 0; i < selected_list.length; i++) {
    total_cost += parseInt(selected_list[i].value);
  }
  document.getElementById('total_label').innerText =
    'Total: ' + total_cost + '  Rs';
  if (typeof checkCompatibility === 'function') checkCompatibility();
}

function checkCompatibility() {
  var el = document.getElementById('compatibility-message');
  if (!el || !window.BUILDER_SPECS) return;
  var specs = window.BUILDER_SPECS;
  var cpuPrice = document.getElementById('cpu_select') && document.getElementById('cpu_select').value;
  var mbPrice = document.getElementById('mb_select') && document.getElementById('mb_select').value;
  var ramPrice = document.getElementById('ram_select') && document.getElementById('ram_select').value;
  var psuPrice = document.getElementById('psu_select') && document.getElementById('psu_select').value;
  var warnings = [];
  var ok = [];
  if (cpuPrice && cpuPrice !== '0' && specs.processor[cpuPrice]) {
    var cpuSocket = (specs.processor[cpuPrice].socket_type || '').trim();
    if (mbPrice && mbPrice !== '0' && specs.motherboard[mbPrice]) {
      var mbSocket = (specs.motherboard[mbPrice].socket_type || '').trim();
      if (cpuSocket && mbSocket && cpuSocket !== mbSocket) {
        warnings.push('CPU socket (' + cpuSocket + ') does not match Motherboard socket (' + mbSocket + ').');
      } else if (cpuSocket && mbSocket) {
        ok.push('CPU and Motherboard sockets match.');
      }
      var mbRam = (specs.motherboard[mbPrice].ram_type || '').trim();
      if (ramPrice && ramPrice !== '0' && specs.ram[ramPrice]) {
        var ramType = (specs.ram[ramPrice].ram_type || '').trim();
        if (mbRam && ramType && mbRam !== ramType) {
          warnings.push('Motherboard RAM type (' + mbRam + ') does not match RAM type (' + ramType + ').');
        } else if (mbRam && ramType) {
          ok.push('RAM type matches motherboard.');
        }
      }
    }
  }
  var psuWatt = psuPrice && psuPrice !== '0' && specs.power_supply[psuPrice] && specs.power_supply[psuPrice].wattage;
  if (psuWatt) ok.push('PSU: ' + psuWatt + 'W.');
  if (warnings.length) {
    el.style.display = 'block';
    el.style.background = 'rgba(239, 68, 68, 0.15)';
    el.style.border = '1px solid rgba(239, 68, 68, 0.4)';
    el.style.color = '#fca5a5';
    el.innerHTML = '<strong>Compatibility warnings:</strong><br>' + warnings.join('<br>');
  } else if (ok.length) {
    el.style.display = 'block';
    el.style.background = 'rgba(54, 236, 78, 0.1)';
    el.style.border = '1px solid rgba(54, 236, 78, 0.3)';
    el.style.color = 'rgba(54, 236, 78, 0.95)';
    el.innerHTML = '<strong>Compatibility:</strong> ' + ok.join(' ');
  } else {
    el.style.display = 'none';
  }
}

function submitSaveBuild() {
  var form = document.getElementById('save-build-form');
  if (!form) return;
  var ids = ['cabinet_select', 'cpu_select', 'gpu_select', 'ram_select', 'mb_select', 'ssd_select', 'hdd_select', 'psu_select', 'cpu_cooler_select'];
  var names = ['save_cabinet', 'save_cpu', 'save_gpu', 'save_ram', 'save_mb', 'save_ssd', 'save_hdd', 'save_power_supply', 'save_cpu_cooler'];
  for (var i = 0; i < ids.length; i++) {
    var sel = document.getElementById(ids[i]);
    var inp = document.getElementById(names[i]);
    if (sel && inp) inp.value = sel.value || '';
  }
  form.submit();
}

function display() {
  if (cabinet_selector.selectedIndex == 1) {
    document.getElementById('cabinet_image').src =
      'images/pc_cabinet/cabinet1.webp';
  } else if (cabinet_selector.selectedIndex == 2) {
    document.getElementById('cabinet_image').src =
      'images/pc_cabinet/cabinet2.webp';
  } else if (cabinet_selector.selectedIndex == 3) {
    document.getElementById('cabinet_image').src =
      'images/pc_cabinet/cabinet3.jpg';
  }
}

function submit_redirect() {
  for (let i = 0; i < dropdowns.length; i++) {
    // let selectedValue = dropdowns[i].options[dropdowns[i].selectedIndex].value;
    if (dropdowns[i].selectedIndex == 0) {
      alert('please ' + dropdowns[i].options[dropdowns[i].selectedIndex].text);
      break;
    }
  }
}

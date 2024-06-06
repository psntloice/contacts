const base_url = "http://localhost:8000/api";

const get_call_module = async (path) => {
  const res = await fetch(`${base_url}/${path}`, {
    headers: {
      "Content-Type": "application/json",
    },
  });

  const res_data = res.json();
  console.log("rtyu 1", res_data);
  return res_data;
};


const post_call_module = async (body, path) => {
  const res = await fetch(`${base_url}/${path}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(body),
  });

  const res_data = res.json();

  return res_data;
};
const put_call_module = async (body, path, theid) => {
  const res = await fetch(`${base_url}/${path}/${theid}`, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(body),
  });

  const res_data = res.json();

  return res_data;
};
const delete_call_module = async (path, theid) => {
  const res = await fetch(`${base_url}/${path}/${theid}`, {
    method: "DELETE",
     });
  
  // const res_data = res.json();

  // return res_data;
};

export { post_call_module, get_call_module, put_call_module, delete_call_module };
